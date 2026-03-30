

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('globalSearchInput');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            let filter = this.value.toLowerCase(); 

            // Cible les cartes ET les lignes de tes différents tableaux
            let searchableItems = document.querySelectorAll('.ticket-card, .project-card, .modern-table tbody tr, .clients-table tbody tr');

            searchableItems.forEach(function(item) {
                let text = item.textContent.toLowerCase(); 
                
                if (text.includes(filter)) {
                    item.style.display = ''; 
                } else {
                    item.style.display = 'none'; 
                }
            });
        });
    }
});