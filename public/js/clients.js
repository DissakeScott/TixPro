
            setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
            }, 50000);
    
    
        

        document.addEventListener('DOMContentLoaded', function() {

    // 1. SCRIPT POUR LA MODALE D'AJOUT
   
    const btnCreateClient = document.querySelector('.btn-create-client');
    
    // On vérifie que le bouton existe sur la page avant d'ajouter l'action
    if (btnCreateClient) {
        btnCreateClient.addEventListener('click', function() {
            document.getElementById('clientModal').style.display = 'flex'; 
        });
    }

    // 2. SCRIPT POUR LA MODALE DE MODIFICATION
    const editButtons = document.querySelectorAll('.btn-edit-client');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            
            // On récupère l'ID pour mettre à jour l'URL du formulaire d'édition
            let clientId = this.getAttribute('data-id');
            document.getElementById('formEditClient').action = `/clients/${clientId}`;

            // On remplit les cases avec les données du bouton cliqué
            document.getElementById('edit_entreprise').value = this.getAttribute('data-entreprise');
            document.getElementById('edit_contact_nom').value = this.getAttribute('data-contact_nom');
            document.getElementById('edit_contact_role').value = this.getAttribute('data-contact_role');
            document.getElementById('edit_email').value = this.getAttribute('data-email');
            document.getElementById('edit_telephone').value = this.getAttribute('data-telephone');
            document.getElementById('edit_adresse').value = this.getAttribute('data-adresse');

            // On affiche la modale
            document.getElementById('editClientModal').style.display = 'flex';
        });
    });

});