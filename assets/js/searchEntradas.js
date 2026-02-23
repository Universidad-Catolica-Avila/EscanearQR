document.addEventListener('DOMContentLoaded', () => {

    /*
    LOGICA DE UN BUSCADOR EN TIEMPO REAL EN JAVASCRIPT
    SOBRE UNA TABLA CON DATOS. SE NECESITA:
            - <input type="text" id="searchInput" placeholder="Buscar por título o categoría..." class="search-input">
            - <table id="entriesTable">
            -   <td class='title-cell'>....
            -   <td class='cat-cell'>....
            
    */

    
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('entriesTable');

    if (searchInput && table) {
        const rows = table.getElementsByTagName('tr');

        searchInput.addEventListener('keyup', () => {
            const filter = searchInput.value.toLowerCase();
            
            // Empezamos en 1 para saltar el encabezado (thead)
            for (let i = 1; i < rows.length; i++) {
                const titleText = rows[i].querySelector('.title-cell').textContent.toLowerCase();
                const catText = rows[i].querySelector('.cat-cell').textContent.toLowerCase();
                const userText = rows[i].querySelector('.user-cell').textContent.toLowerCase();
                const dateText = rows[i].querySelector('.date-cell').textContent.toLowerCase();
                
                if (titleText.includes(filter) || catText.includes(filter) || userText.includes(filter) || dateText.includes(filter)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });
    }

});
