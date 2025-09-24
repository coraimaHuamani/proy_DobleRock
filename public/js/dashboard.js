import { cargarNoticias } from "./noticias/cargarNoticias.js";

document.addEventListener('DOMContentLoaded', () => {
    const panels = {
        categorias: document.getElementById('panel-categorias'),
        productos: document.getElementById('panel-productos'),
        usuarios: document.getElementById('panel-usuarios'),
        galeria: document.getElementById('panel-galeria'),
        noticias: document.getElementById('panel-noticias')
    };

    // Función para ocultar todos los paneles
    function hideAllPanels() {
        Object.values(panels).forEach(panel => {
            if (panel) panel.classList.add('hidden');
        });
    }

    document.getElementById('menu-categorias')?.addEventListener('click', () => {
        hideAllPanels();
        panels.categorias?.classList.remove('hidden');
        
        // Cargar categorías cuando se muestre el panel
        if (typeof cargarCategorias === "function") {
            setTimeout(cargarCategorias, 100);
        }
    });

    document.getElementById('menu-productos')?.addEventListener('click', () => {
        hideAllPanels();
        panels.productos?.classList.remove('hidden');
    });

    document.getElementById('menu-usuarios')?.addEventListener('click', () => {
        hideAllPanels();
        panels.usuarios?.classList.remove('hidden');
        
        // Cargar usuarios cuando se muestre el panel
        if (typeof cargarUsuarios === "function") {
            setTimeout(cargarUsuarios, 100);
        }
    });

    document.getElementById('menu-galeria')?.addEventListener('click', () => {
        hideAllPanels();
        panels.galeria?.classList.remove('hidden');
        
        // Cargar galería cuando se muestre el panel
        if (typeof cargarGaleria === "function") {
            setTimeout(cargarGaleria, 100);
        }
    });

    document.getElementById('menu-noticias')?.addEventListener('click', async() => {
        hideAllPanels();
        panels.noticias?.classList.remove('hidden');

        cargarNoticias();
    });

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