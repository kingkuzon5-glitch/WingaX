function toast(message) {
    const el = document.createElement('div');
    el.textContent = message;
    el.className =
        'fixed bottom-24 md:bottom-8 left-1/2 -translate-x-1/2 bg-on-background text-background text-sm font-medium px-4 py-2 rounded-full shadow-lg z-[100] transition-opacity duration-300';
    document.body.appendChild(el);

    setTimeout(() => {
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 300);
    }, 1800);
}

document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-share]');
    if (!button) return;

    const url = button.dataset.shareUrl;
    const title = button.dataset.shareTitle || document.title;

    if (navigator.share) {
        try {
            await navigator.share({ title, url });
        } catch (error) {
            // user cancelled the native share sheet — nothing to do
        }
        return;
    }

    try {
        await navigator.clipboard.writeText(url);
        toast('Link copied to clipboard');
    } catch (error) {
        window.prompt('Copy this link:', url);
    }
});
