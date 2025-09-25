import { cargarNoticias } from "./noticias/cargarNoticias.js";

document.addEventListener('DOMContentLoaded', () => {
    const panels = {
        categorias: document.getElementById('panel-categorias'),
        productos: document.getElementById('panel-productos'),
        usuarios: document.getElementById('panel-usuarios'),
        galeria: document.getElementById('panel-galeria'),
        noticias: document.getElementById('panel-noticias'),
        clientes: document.getElementById('panel-clientes')
    };

    // Función para ocultar todos los paneles
    function hideAllPanels() {
        Object.values(panels).forEach(panel => {
            if (panel) panel.classList.add('hidden');
        });
    }

    // Función para resetear formularios y mostrar listas
    function resetAllFormsToList() {
        // CATEGORÍAS - volver a lista
        const categoriaCreateSection = document.getElementById('categorias-create-section');
        const categoriaEditSection = document.getElementById('categorias-edit-section');
        const categoriaContainer = document.getElementById('categorias-container');
        const btnCreateCategoria = document.getElementById('btn-create-categoria');
        
        if (categoriaCreateSection) categoriaCreateSection.classList.add('hidden');
        if (categoriaEditSection) categoriaEditSection.classList.add('hidden');
        if (categoriaContainer) categoriaContainer.classList.remove('hidden');
        if (btnCreateCategoria) btnCreateCategoria.classList.remove('hidden');

        // PRODUCTOS - volver a lista
        const productoCreateSection = document.getElementById('productos-create-section');
        const productoEditSection = document.getElementById('productos-edit-section');
        const productoContainer = document.getElementById('productos-container');
        const btnCreateProducto = document.getElementById('btn-create-producto');
        
        if (productoCreateSection) productoCreateSection.classList.add('hidden');
        if (productoEditSection) productoEditSection.classList.add('hidden');
        if (productoContainer) productoContainer.classList.remove('hidden');
        if (btnCreateProducto) btnCreateProducto.classList.remove('hidden');

        // USUARIOS - volver a lista
        const userCreateSection = document.getElementById('users-create-section');
        const userEditSection = document.getElementById('users-edit-section');
        const userContainer = document.getElementById('users-container');
        const btnCreateUser = document.getElementById('btn-create-user');
        
        if (userCreateSection) userCreateSection.classList.add('hidden');
        if (userEditSection) userEditSection.classList.add('hidden');
        if (userContainer) userContainer.classList.remove('hidden');
        if (btnCreateUser) btnCreateUser.classList.remove('hidden');

        // GALERÍA - volver a lista
        const galeriaCreateSection = document.getElementById('galeria-create-section');
        const galeriaEditSection = document.getElementById('galeria-edit-section');
        const galeriaContainer = document.getElementById('galeria-container');
        const btnCreateGaleria = document.getElementById('btn-create-galeria');
        
        if (galeriaCreateSection) galeriaCreateSection.classList.add('hidden');
        if (galeriaEditSection) galeriaEditSection.classList.add('hidden');
        if (galeriaContainer) galeriaContainer.classList.remove('hidden');
        if (btnCreateGaleria) btnCreateGaleria.classList.remove('hidden');

        // NOTICIAS - volver a lista
        const newsCreateSection = document.getElementById('news-create-section');
        const newsEditSection = document.getElementById('news-edit-section');
        const newsContainer = document.getElementById('news-container');
        const btnCreateNews = document.getElementById('btn-create-news');
        
        if (newsCreateSection) newsCreateSection.classList.add('hidden');
        if (newsEditSection) newsEditSection.classList.add('hidden');
        if (newsContainer) newsContainer.classList.remove('hidden');
        if (btnCreateNews) btnCreateNews.classList.remove('hidden');

        // CLIENTES - volver a lista
        const clienteCreateSection = document.getElementById('clientes-create-section');
        const clienteEditSection = document.getElementById('clientes-edit-section');
        const clienteContainer = document.getElementById('clientes-container');
        const btnCreateCliente = document.getElementById('btn-create-cliente');
        
        if (clienteCreateSection) clienteCreateSection.classList.add('hidden');
        if (clienteEditSection) clienteEditSection.classList.add('hidden');
        if (clienteContainer) clienteContainer.classList.remove('hidden');
        if (btnCreateCliente) btnCreateCliente.classList.remove('hidden');
    }

    document.getElementById('menu-categorias')?.addEventListener('click', () => {
        hideAllPanels();
        resetAllFormsToList(); // Resetear todos los formularios
        panels.categorias?.classList.remove('hidden');
        
        // Cargar categorías cuando se muestre el panel
        if (typeof cargarCategorias === "function") {
            setTimeout(cargarCategorias, 100);
        }
    });

    document.getElementById('menu-productos')?.addEventListener('click', () => {
        hideAllPanels();
        resetAllFormsToList(); // Resetear todos los formularios
        panels.productos?.classList.remove('hidden');
        
        // Cargar productos cuando se muestre el panel
        if (typeof cargarProductos === "function") {
            setTimeout(cargarProductos, 100);
        }
    });

    document.getElementById('menu-usuarios')?.addEventListener('click', () => {
        hideAllPanels();
        resetAllFormsToList(); // Resetear todos los formularios
        panels.usuarios?.classList.remove('hidden');
        
        // Cargar usuarios cuando se muestre el panel
        if (typeof cargarUsuarios === "function") {
            setTimeout(cargarUsuarios, 100);
        }
    });

    document.getElementById('menu-galeria')?.addEventListener('click', () => {
        hideAllPanels();
        resetAllFormsToList(); // Resetear todos los formularios
        panels.galeria?.classList.remove('hidden');
        
        // Cargar galería cuando se muestre el panel
        if (typeof cargarGaleria === "function") {
            setTimeout(cargarGaleria, 100);
        }
    });

    document.getElementById('menu-noticias')?.addEventListener('click', async() => {
        hideAllPanels();
        resetAllFormsToList(); // Resetear todos los formularios
        panels.noticias?.classList.remove('hidden');

        cargarNoticias();
    });

    document.getElementById('menu-clientes')?.addEventListener('click', () => {
        hideAllPanels();
        resetAllFormsToList();
        panels.clientes?.classList.remove('hidden');
        
        // Cargar clientes cuando se muestre el panel
        if (typeof cargarClientes === "function") {
            setTimeout(cargarClientes, 100);
        }
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