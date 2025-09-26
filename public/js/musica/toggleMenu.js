document.addEventListener("DOMContentLoaded", () => {
    const menuMusica = document.getElementById("menu-musica");
    const submenuMusica = document.getElementById("submenu-musica");
    const chevron = document.getElementById("music-chevron");

  if (!menuMusica || !submenuMusica || !chevron) {
    console.error("Elementos no encontrados");  
    return;
  }
  
  menuMusica.addEventListener("click", () => {
        submenuMusica.classList.toggle("hidden");
        chevron.classList.toggle("rotate-180");
    });
});
