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

    initRoleForms();
    initRoleTabs();
});

function normalizePath(pathname) {
    return pathname.replace(/\/$/, '') || '/';
}

function initRoleForms() {
    const config = {
        estudiante: {
            label: 'Programa o grado (estudiante)',
            placeholder: 'Ej. Ingeniería en Sistemas, 5to semestre...'
        },
        profesor: {
            label: 'Especialidad o cátedra (profesor)',
            placeholder: 'Ej. Matemáticas discretas, tutoría de laboratorio...'
        },
        universidad: {
            label: 'Notas de institución / campus',
            placeholder: 'Ej. Universidad Central, Campus Norte, tipo de convenio...'
        }
    };

    document.querySelectorAll('[data-role-select]').forEach((select) => {
        const form = select.closest('form') || document;
        const label = form.querySelector('[data-role-label]');
        const field = form.querySelector('[data-role-field]');
        const update = () => {
            const role = select.value || 'estudiante';
            const copy = config[role] || config.estudiante;
            if (label) label.textContent = copy.label;
            if (field) field.placeholder = copy.placeholder;
        };
        select.addEventListener('change', update);
        update();
    });
}

function initRoleTabs() {
    const tabs = document.querySelectorAll('.role-tab');
    const panels = document.querySelectorAll('.role-panel');
    if (!tabs.length || !panels.length) return;

    const activate = (role) => {
        tabs.forEach((tab) => tab.classList.toggle('is-active', tab.dataset.roleTab === role));
        panels.forEach((panel) => panel.classList.toggle('is-active', panel.dataset.rolePanel === role));
    };

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            activate(tab.dataset.roleTab);
        });
    });

    document.querySelectorAll('.role-tab-trigger').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const target = trigger.dataset.roleTab;
            if (target) {
                activate(target);
                const panel = document.querySelector('[data-role-panel="' + target + '"]');
                if (panel) {
                    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
}
