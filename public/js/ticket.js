/**
 * GESTION DES TICKETS - INTERFACE UTILISATEUR (UI)
 */
document.addEventListener('DOMContentLoaded', () => {

    // =========================================================
    // 1. SÉLECTION DES ÉLÉMENTS
    // =========================================================
    const modalCreate = document.getElementById('modalTicket');
    const btnOpenCreate = document.getElementById('btnOpenModal'); 

    const modalDetails = document.getElementById('modalTicketDetails');
    const modalEdit = document.getElementById('modalEditTicket'); 
    
    // 🎯 NOUVEAU : On sélectionne la modale de temps et son bouton
    const modalSaisieTemps = document.getElementById('modalSaisieTemps');
    const btnGoToSaisieTemps = document.getElementById('btnGoToSaisieTemps');
    
    const btnsViewDetails = document.querySelectorAll('.php-btn-details');
    const btnOpenEditTicket = document.getElementById('btnOpenEditTicket');
    
    const filterTabs = document.querySelectorAll('.filter-tab');
    const ticketCards = document.querySelectorAll('.ticket-card');



    // =========================================================
    // 2. OUVERTURE & FERMETURE DES MODALES (Général)
    // =========================================================
    
    if (btnOpenCreate) {
        btnOpenCreate.addEventListener('click', () => {
            modalCreate.style.display = 'flex';
        });
    }

    // Fermeture en cliquant dans le vide
    window.addEventListener('click', (e) => {
        if (e.target === modalCreate) modalCreate.style.display = 'none';
        if (e.target === modalDetails) modalDetails.style.display = 'none';
        if (e.target === modalEdit) modalEdit.style.display = 'none';
        if (e.target === modalSaisieTemps) modalSaisieTemps.style.display = 'none'; // 🎯 NOUVEAU
    });

    
    // =========================================================
    // 3. INJECTION DES DONNÉES & TRANSITIONS
    // =========================================================

    btnsViewDetails.forEach(btn => {
        btn.addEventListener('click', function() {
            
            // a) Lecture des attributs du ticket cliqué
            const id        = this.getAttribute('data-id');
            const titre     = this.getAttribute('data-titre');
            const projet_id = this.getAttribute('data-projet_id'); 
            const projet    = this.getAttribute('data-projet');
            const priorite  = this.getAttribute('data-priorite');
            const type      = this.getAttribute('data-type');
            const temps     = this.getAttribute('data-temps');
            const statut    = this.getAttribute('data-statut');
            const desc      = this.getAttribute('data-desc');
            const collaborateur = this.getAttribute('data-collaborateur');
            const pillClass = this.getAttribute('data-pill');

            // b) Remplissage de la modale DÉTAILS
            document.getElementById('viewTicketTitle').textContent = titre;
            document.getElementById('viewTicketProject').textContent = projet;
            document.getElementById('viewTicketPriority').textContent = priorite;
            document.getElementById('viewTicketPriority').className = 'priority-pill ' + pillClass;
            document.getElementById('viewTicketType').textContent = type;
            document.getElementById('viewTicketTime').textContent = temps + ' h';
            document.getElementById('viewTicketDesc').textContent = desc || "Aucune description fournie.";
            document.getElementById('viewTicketCollaborator').textContent = collaborateur;
            document.getElementById('viewTicketStatus').textContent = statut;

            // 🎯 NOUVEAU : On passe "secrètement" l'ID au bouton de Saisie de Temps
            if(btnGoToSaisieTemps) {
                btnGoToSaisieTemps.setAttribute('data-id', id);
            }

            // c) Pré-remplissage INVISIBLE de la modale ÉDITION
            document.getElementById('formEditTicket').action = `/tickets/${id}`; 
            document.getElementById('formDeleteTicket').action = `/tickets/${id}`; 
            document.getElementById('editTicketTitle').value = titre;
            document.getElementById('editTicketProject').value = projet_id; 
            document.getElementById('editTicketStatus').value = statut;
            document.getElementById('editTicketPriority').value = priorite;
            document.getElementById('editTicketTime').value = temps;
            document.getElementById('editTicketDesc').value = desc;
            document.getElementById('editTicketType').value = type;

            const btnSaisieTemps = document.getElementById('btnGoToSaisieTemps');
            
            if (type === 'Facturable') {
                // Si c'est facturable, on cache complètement le bouton
                btnSaisieTemps.style.display = 'none';
            } else {
                // Sinon (si c'est Inclus), on s'assure qu'il est bien visible
                btnSaisieTemps.style.display = 'block'; 
                // Note : si ton bouton utilisait 'flex' ou 'inline-block' dans ton CSS de base, remets cette valeur à la place de 'block'
            }

            // d) Ouverture de la modale de détails
            modalDetails.style.display = 'flex';
        });
    });

    // e) GESTION DU CLIC SUR LE BOUTON "MODIFIER"
    if (btnOpenEditTicket) {
        btnOpenEditTicket.addEventListener('click', function() {
            modalDetails.style.display = 'none'; 
            modalEdit.style.display = 'flex';    
        });
    }

    // =========================================================
    // 4. GESTION DES FILTRES DE PRIORITÉ
    // =========================================================
    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            
            filterTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const filterValue = tab.getAttribute('data-filter');

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



    // =========================================================
    // 5. GESTION DE LA SAISIE DE TEMPS (LA MODALE FINALE)
    // =========================================================

    if (btnGoToSaisieTemps) {
        btnGoToSaisieTemps.addEventListener('click', function() {
            // 1. On récupère l'ID du ticket que la modale Détail nous a transmis
            let ticketId = this.getAttribute('data-id');
        
            // 2. On met à jour l'URL du formulaire d'enregistrement du temps
            document.getElementById('formSaisieTemps').action = `/tickets/${ticketId}/temps`;
            
            // 3. On ferme la modale des détails et on ouvre celle du temps
            modalDetails.style.display = 'none';
            modalSaisieTemps.style.display = 'flex';
        });
         
    
    
    }

});