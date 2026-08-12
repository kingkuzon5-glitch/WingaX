const STORAGE_KEY = 'wingax_recent_searches';
const MAX_RECENT = 5;

function getRecent() {
    try {
        return JSON.parse(localStorage.getItem(STORAGE_KEY)) ?? [];
    } catch (error) {
        return [];
    }
}

function saveRecent(term) {
    const recent = getRecent().filter((item) => item.toLowerCase() !== term.toLowerCase());
    recent.unshift(term);
    localStorage.setItem(STORAGE_KEY, JSON.stringify(recent.slice(0, MAX_RECENT)));
}

function renderRecent() {
    const list = document.getElementById('recent-searches-list');
    const section = document.getElementById('recent-searches-section');
    if (!list || !section) return;

    const recent = getRecent();
    if (recent.length === 0) {
        section.classList.add('hidden');
        return;
    }

    section.classList.remove('hidden');
    list.innerHTML = recent
        .map(
            (term) => `
        <li class="flex items-center gap-sm p-xs hover:bg-surface-container-highest rounded-lg transition-colors cursor-pointer" data-term="${term.replace(/"/g, '&quot;')}">
            <span class="material-symbols-outlined text-secondary">history</span>
            <span class="font-body-sm text-body-sm text-on-surface flex-grow">${term}</span>
            <span class="material-symbols-outlined text-on-surface-variant/50 text-sm">north_west</span>
        </li>`
        )
        .join('');

    list.querySelectorAll('[data-term]').forEach((item) => {
        item.addEventListener('click', () => {
            const url = new URL(window.location.href);
            url.searchParams.set('q', item.dataset.term);
            window.location.href = url.toString();
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const q = params.get('q');
    if (q && q.trim() !== '') {
        saveRecent(q.trim());
    }

    renderRecent();

    const clearBtn = document.getElementById('clear-recent-searches');
    clearBtn?.addEventListener('click', () => {
        localStorage.removeItem(STORAGE_KEY);
        renderRecent();
    });
});
