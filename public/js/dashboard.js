document.addEventListener('DOMContentLoaded', () => {
    const panels = {
        productos: document.getElementById('panel-productos'),
        usuarios: document.getElementById('panel-usuarios'),
        galeria: document.getElementById('panel-galeria')
    };
    document.getElementById('menu-productos').onclick = () => {
        panels.productos.classList.remove('hidden');
        panels.usuarios.classList.add('hidden');
        panels.galeria.classList.add('hidden');
    };
    document.getElementById('menu-usuarios').onclick = () => {
        panels.productos.classList.add('hidden');
        panels.usuarios.classList.remove('hidden');
        panels.galeria.classList.add('hidden');
    };
    document.getElementById('menu-galeria').onclick = () => {
        panels.productos.classList.add('hidden');
        panels.usuarios.classList.add('hidden');
        panels.galeria.classList.remove('hidden');
    };

    // Menú hamburguesa para móvil
    const sidebar = document.getElementById('dashboard-sidebar');
    const overlay = document.getElementById('dashboard-overlay');
    const toggle = document.getElementById('dashboard-menu-toggle');
    if(toggle) {
        toggle.onclick = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
    }
    if(overlay) {
        overlay.onclick = () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        };
    }
});