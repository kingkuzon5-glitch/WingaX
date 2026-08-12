const container = document.getElementById('feed-container');

if (container) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const viewedUrls = new Set();
    let loadingMore = false;

    const activateVideo = (video) => {
        if (video && !video.src) {
            video.src = video.dataset.src;
        }
        video?.play().catch(() => {});
    };

    const deactivateVideo = (video) => {
        video?.pause();
    };

    const pingView = (viewUrl) => {
        if (!viewUrl || viewedUrls.has(viewUrl)) return;
        viewedUrls.add(viewUrl);

        fetch(viewUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken ?? '',
                Accept: 'application/json',
            },
            keepalive: true,
        }).catch(() => {});
    };

    const itemObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const section = entry.target;
                const video = section.querySelector('video[data-src]');

                if (entry.isIntersecting && entry.intersectionRatio >= 0.6) {
                    activateVideo(video);

                    const timer = setTimeout(() => {
                        if (entry.isIntersecting) {
                            pingView(section.dataset.viewUrl);
                        }
                    }, 1500);
                    section.dataset.viewTimer = String(timer);
                } else {
                    deactivateVideo(video);

                    if (section.dataset.viewTimer) {
                        clearTimeout(Number(section.dataset.viewTimer));
                        delete section.dataset.viewTimer;
                    }
                }
            });
        },
        { root: container, threshold: [0, 0.6, 1] }
    );

    const observeItem = (section) => itemObserver.observe(section);
    container.querySelectorAll('.feed-item').forEach(observeItem);

    const loadMore = async () => {
        const sentinel = document.getElementById('feed-sentinel');
        if (!sentinel || loadingMore) return;

        const cursor = sentinel.dataset.cursor;
        if (!cursor) {
            sentinel.remove();
            return;
        }

        loadingMore = true;

        const url = new URL(container.dataset.moreUrl, window.location.origin);
        url.searchParams.set('cursor', cursor);

        try {
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const html = await response.text();

            const temp = document.createElement('div');
            temp.innerHTML = html;

            temp.querySelectorAll('.feed-item').forEach((item) => {
                sentinel.before(item);
                observeItem(item);
            });

            const newSentinel = temp.querySelector('#feed-sentinel');
            if (newSentinel && newSentinel.dataset.cursor) {
                sentinel.dataset.cursor = newSentinel.dataset.cursor;
            } else {
                sentinel.remove();
            }
        } catch (error) {
            // network hiccup — the sentinel stays put, next scroll will retry
        } finally {
            loadingMore = false;
        }
    };

    const sentinelObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    loadMore();
                }
            });
        },
        { root: container, threshold: 0.1 }
    );

    const sentinel = document.getElementById('feed-sentinel');
    if (sentinel) sentinelObserver.observe(sentinel);
}
