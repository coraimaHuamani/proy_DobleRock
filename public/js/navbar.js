document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('close-menu');
    const overlay = document.getElementById('overlay');

    if (!btn || !menu || !closeBtn || !overlay) return;

    btn.addEventListener('click', () => {
        menu.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => {
        menu.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    overlay.addEventListener('click', () => {
        menu.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
});
