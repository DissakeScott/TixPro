/**
 * GESTION DES TICKETS - INTERFACE UTILISATEUR (UI)
 */
document.addEventListener('DOMContentLoaded', () => {

    // =========================================================
    // 1. SÉLECTION DES ÉLÉMENTS
    // =========================================================
    const modalCreate = document.getElementById('modalTicket');
    const btnOpenCreate = document.getElementById('btnOpenModal'); // 👈 On remet le bouton de création !

    const modalDetails = document.getElementById('modalTicketDetails');
    const modalEdit = document.getElementById('modalEditTicket'); // L'ajout de tout à l'heure
    
    const btnsViewDetails = document.querySelectorAll('.php-btn-details');
    const btnOpenEditTicket = document.getElementById('btnOpenEditTicket');
    
    const filterTabs = document.querySelectorAll('.filter-tab');
    const ticketCards = document.querySelectorAll('.ticket-card');

    // =========================================================
    // 2. OUVERTURE & FERMETURE DES MODALES (Général)
    // =========================================================
    
    // 🚀 L'ÉVÉNEMENT MANQUANT : Ouvrir la création
    if (btnOpenCreate) {
        btnOpenCreate.addEventListener('click', () => {
            modalCreate.style.display = 'flex';
        });
    }

    // Fermeture en cliquant dans le vide (à l'extérieur de la carte)
    window.addEventListener('click', (e) => {
        if (e.target === modalCreate) modalCreate.style.display = 'none';
        if (e.target === modalDetails) modalDetails.style.display = 'none';
        if (e.target === modalEdit) modalEdit.style.display = 'none';
    });

    
    
    // =========================================================
    // 3. INJECTION DES DONNÉES & TRANSITION VERS L'ÉDITION
    // =========================================================


    

    btnsViewDetails.forEach(btn => {
        btn.addEventListener('click', function() {
            
            // a) Lecture des attributs du ticket cliqué
            const id        = this.getAttribute('data-id');
            const titre     = this.getAttribute('data-titre');
            const projet_id = this.getAttribute('data-projet_id'); // L'ID du projet !
            const projet    = this.getAttribute('data-projet');
            const priorite  = this.getAttribute('data-priorite');
            const type      = this.getAttribute('data-type');
            const temps     = this.getAttribute('data-temps');
            const statut    = this.getAttribute('data-statut');
            const desc      = this.getAttribute('data-desc');
            const pillClass = this.getAttribute('data-pill');

            // b) Remplissage de la modale DÉTAILS
            document.getElementById('viewTicketTitle').textContent = titre;
            document.getElementById('viewTicketProject').textContent = projet;
            document.getElementById('viewTicketPriority').textContent = priorite;
            document.getElementById('viewTicketPriority').className = 'priority-pill ' + pillClass;
            document.getElementById('viewTicketType').textContent = type;
            document.getElementById('viewTicketTime').textContent = temps + ' h';
            document.getElementById('viewTicketDesc').textContent = desc || "Aucune description fournie.";

            // c) Pré-remplissage INVISIBLE de la modale ÉDITION
            document.getElementById('formEditTicket').action = `/tickets/${id}`; // URL de mise à jour
            document.getElementById('formDeleteTicket').action = `/tickets/${id}`; 
            document.getElementById('editTicketTitle').value = titre;
            document.getElementById('editTicketTitle').value = titre;
            document.getElementById('editTicketProject').value = projet_id; // Sélectionne le bon projet dans la liste
            document.getElementById('editTicketStatus').value = statut;
            document.getElementById('editTicketPriority').value = priorite;
            document.getElementById('editTicketTime').value = temps;
            document.getElementById('editTicketDesc').value = desc;
            document.getElementById('editTicketType').value = type;

            // d) Ouverture de la modale de détails
            modalDetails.style.display = 'flex';
        });
    });

    // e) GESTION DU CLIC SUR LE BOUTON "MODIFIER"
    if (btnOpenEditTicket) {
        btnOpenEditTicket.addEventListener('click', function() {
            modalDetails.style.display = 'none'; // Ferme les détails
            modalEdit.style.display = 'flex';    // Ouvre le formulaire pré-rempli
        });
    }

    // Ajoute la fermeture de la modale d'édition en cliquant à l'extérieur (dans la section 2 de ton JS)
    window.addEventListener('click', (e) => {
        if (e.target === modalCreate) modalCreate.style.display = 'none';
        if (e.target === modalDetails) modalDetails.style.display = 'none';
        if (e.target === modalEdit) modalEdit.style.display = 'none'; // NOUVEAU
    });



    // =========================================================
    // 4. GESTION DES FILTRES DE PRIORITÉ
    // =========================================================
    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            
            // On gère l'état visuel du bouton de filtre actif
            filterTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const filterValue = tab.getAttribute('data-filter');

            // On affiche ou cache les cartes
            ticketCards.forEach(card => {
                const cardPriority = card.getAttribute('data-priority');
                const cardType = card.getAttribute('data-type');
                if (filterValue === 'all' || cardPriority === filterValue || cardType === filterValue) {
                    card.style.display = 'flex'; 
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

});