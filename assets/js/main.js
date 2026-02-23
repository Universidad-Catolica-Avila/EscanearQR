document.addEventListener('DOMContentLoaded', () => {
    // 1. Lógica Menú Hamburguesa (Móvil)
    const toggle = document.querySelector('.menu-toggle');
    const links = document.querySelector('.nav-links');

    if (toggle && links) {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            links.classList.toggle('active');
        });
    }

    // 2. Lógica Menú Desplegable Usuario
    const userBtn = document.getElementById('userMenuBtn');
    const userMenu = document.getElementById('userMenu');

    if (userBtn && userMenu) {
        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('show');
            
            // Opcional: rotar la flecha al abrir
            const arrow = userBtn.querySelector('.arrow');
            if (arrow) arrow.style.transform = userMenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    }

    // 3. Cerrar menús al hacer clic fuera
    window.addEventListener('click', () => {
        if (userMenu && userMenu.classList.contains('show')) {
            userMenu.classList.remove('show');
            const arrow = userBtn.querySelector('.arrow');
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        }
        // Opcional: cerrar menú móvil al hacer clic fuera
        if (links && links.classList.contains('active')) {
            links.classList.remove('active');
        }
    });



/* =========================================
   LÓGICA DE NOTIFICACIONES (VERSIÓN FINAL)
   ========================================= */

    const toast = document.getElementById('toastContainer');

    if (toast) {
    console.log("Toast detectado. Iniciando temporizador...");

    const desaparecer = () => {
        console.log("Iniciando desaparición...");
        
        // 1. Forzamos el estilo directamente por JS para evitar fallos de CSS
        toast.style.transition = "all 0.6s ease";
        toast.style.opacity = "0";
        toast.style.transform = "translateX(-50%) translateY(-20px)";

        // 2. Lo eliminamos del DOM físicamente tras la animación
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
                console.log("Toast eliminado del DOM.");
            }
        }, 600);
    };

    // Auto-ocultar a los 4 segundos
    setTimeout(desaparecer, 4000);

    // Cerrar al hacer clic
    toast.addEventListener('click', desaparecer);
}
});
