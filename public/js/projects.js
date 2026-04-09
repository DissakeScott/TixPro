/**
 * GESTION DES PROJETS - JS OPTIMISÉ POUR LARAVEL
 */

document.addEventListener('DOMContentLoaded', () => {

    // =========================================================
    // 1. SÉLECTION DES ÉLÉMENTS
    // =========================================================
    const modalCreate = document.getElementById('modalProject');
    const modalDetails = document.getElementById('modalProjectDetails');
    const btnOpenCreate = document.getElementById('btnOpenProjectModal');
    const btnsViewDetails = document.querySelectorAll('.php-btn-details');
    const filterTabs = document.querySelectorAll('.filter-tab');
    const projectCards = document.querySelectorAll('.project-card');

    if (!modalCreate || !modalDetails) return;

    // =========================================================
    // 2. OUVERTURE ET FERMETURE DES MODALES
    // =========================================================
    
    // Ouvrir la modale de création
    if (btnOpenCreate) {
        btnOpenCreate.addEventListener('click', () => {
            modalCreate.style.display = 'flex';
        });
    }

    // Fermer en cliquant en dehors des modales
    window.addEventListener('click', (e) => {
        if (e.target === modalCreate) modalCreate.style.display = 'none';
        if (e.target === modalDetails) modalDetails.style.display = 'none';
        if (e.target === modalEdit) modalEdit.style.display = 'none';
    });

    // =========================================================
    // 3. GESTION DES FILTRES
    // =========================================================
    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Visuel du bouton actif
            filterTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            const filterValue = tab.getAttribute('data-filter');
            
            // Tri des cartes
            projectCards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                if (filterValue === 'all' || cardStatus === filterValue) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

// =========================================================
    // 4. INJECTION DES DÉTAILS ET MODIFICATION
    // =========================================================
    const modalEdit = document.getElementById('modalEditProject');
    const btnOpenEdit = document.getElementById('btnOpenEditProject');

    btnsViewDetails.forEach(btn => {
        btn.addEventListener('click', function() {
            
            // a) Récupération des données
            const id = this.getAttribute('data-id'); // NOUVEAU
            const nom = this.getAttribute('data-nom');
            const client_id = this.getAttribute('data-client_id'); // NOUVEAU
            const client = this.getAttribute('data-client');
            const statut = this.getAttribute('data-statut');
            const badgeClass = this.getAttribute('data-badge');
            const debut = this.getAttribute('data-debut');
            const fin = this.getAttribute('data-fin');
            const heures = this.getAttribute('data-heures');
            const desc = this.getAttribute('data-desc');

            // b) Injection dans la modale de DÉTAILS
            document.getElementById('viewProjClient').textContent = client;
            document.getElementById('viewProjTitle').textContent = nom;
            const statusBadge = document.getElementById('viewProjStatus');
            statusBadge.textContent = statut;
            statusBadge.className = `status-pill ${badgeClass}`;
            document.getElementById('viewProjStart').textContent = formatDate(debut);
            document.getElementById('viewProjEnd').textContent = formatDate(fin);
            document.getElementById('viewProjHours').textContent = heures + ' h';
            document.getElementById('viewProjDesc').textContent = desc || "Aucune description fournie.";

            // c) Pré-remplissage INVISIBLE de la modale ÉDITION et de SUPPRESSION
            document.getElementById('formEditProject').action = `/projets/${id}`;
            document.getElementById('formDeleteProject').action = `/projets/${id}`;
            
            document.getElementById('editProjNom').value = nom;
            document.getElementById('editProjClient').value = client_id;
            document.getElementById('editProjStatut').value = statut;
            document.getElementById('editProjDebut').value = debut;
            document.getElementById('editProjFin').value = fin;
            document.getElementById('editProjHeures').value = heures;
            document.getElementById('editProjDesc').value = desc;
            document.getElementById('viewProjConsommees').textContent = this.dataset.consommees;
            document.getElementById('viewProjHours').textContent = this.dataset.heures;
            
            let restantes = this.dataset.restantes;
            let restEle = document.getElementById('viewProjRestantes');
            restEle.textContent = restantes;
            // Si les heures sont négatives, on met le texte en rouge
            restEle.style.color = (parseFloat(restantes) < 0) ? '#ef4444' : '#1e293b';

            document.getElementById('viewProjTaux').textContent = this.dataset.taux;

            // Met à jour la barre de progression (largeur et couleur)
            let progressBar = document.getElementById('viewProjProgressBar');
            progressBar.style.width = this.dataset.pourcentage + '%';
            progressBar.className = 'progress-bar ' + this.dataset.couleur;
            
            // Et on n'oublie pas de remplir le formulaire d'édition au cas où on clique sur "Modifier"
            document.getElementById('editProjTaux').value = this.dataset.taux;


            // d) Affichage de la modale des détails
            modalDetails.style.display = 'flex';
        });
    });

    // e) GESTION DU CLIC SUR "MODIFIER"
    if (btnOpenEdit) {
        btnOpenEdit.addEventListener('click', () => {
            modalDetails.style.display = 'none'; // Ferme les détails
            modalEdit.style.display = 'flex';    // Ouvre le formulaire
        });
    }

    // N'oublie pas d'ajouter la fermeture de `modalEdit` dans ta section 2 (Clic en dehors des modales) :

// =========================================================
// 5. FONCTION UTILITAIRE (Formatage Date)
// =========================================================

function formatDate(d) {
    if (!d || d === "-") return "-";
    const date = new Date(d);
    return isNaN(date.getTime()) ? "-" : date.toLocaleDateString('fr-FR');
}
});