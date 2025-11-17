// Comportamiento común para la navegación y confirmaciones

document.addEventListener('DOMContentLoaded', () => {
    const current = normalizePath(window.location.pathname);
    const links = document.querySelectorAll('.nav-link');

    links.forEach((link) => {
        const href = link.getAttribute('href');
        if (!href) return;
        const normalized = normalizePath(new URL(href, window.location.origin).pathname);
        if (current === normalized || current.startsWith(normalized + '/')) {
            link.classList.add('is-active');
            link.setAttribute('aria-current', 'page');
        }
    });

    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const message = form.getAttribute('data-confirm') || '¿Deseas continuar?';
            if (!confirm(message)) {
                event.preventDefault();
            }
        });
    });
});

function normalizePath(pathname) {
    return pathname.replace(/\/$/, '') || '/';
}
