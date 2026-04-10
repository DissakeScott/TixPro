<?php $__env->startSection('title', 'Liste des Clients - TixPro'); ?>



<!-- affichage de la liste des clients avec possibilité de créer, modifier et supprimer un client. -->

<?php $__env->startSection('content'); ?>
    <div class="section-header-row">
        <h2>Listes des clients</h2>
       <?php if(Auth::user()->role === 'Administrateur'): ?>
        <button class="btn-create-client"><i class="fa-solid fa-plus"></i> Ajouter un client</button>
        <?php endif; ?>
    </div>
      <section class="clients-section">
                
                <div class="table-container shadow-card">
                    <table class="clients-table">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Contact</th>
                                <th>Coordonnées</th> 
                                <th style="text-align: center;">Projets actifs</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
    <tbody id="clientsListBody">
    <?php if($clients->isEmpty()): ?>
        <tr class="empty-state" id="noClientMessage">
            <td colspan="6">Aucun client enregistré pour le moment.</td>
        </tr>
    <?php else: ?>
        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                
                $statut = $client->statut ?? 'Actif'; 
                $badgeStatut = ($statut === 'Actif') ? 'badge-actif' : 'badge-inactif';
            ?>
            <tr>
                <td>
                    <strong><?php echo e($client->entreprise); ?></strong><br>
                    <small class="text-muted"><?php echo e($client->adresse); ?></small>
                </td>
                <td>
                    <strong><?php echo e($client->contact_nom); ?></strong><br>
                    <span class="text-muted"><?php echo e($client->contact_role); ?></span>
                </td>
                <td>
                    <a href="mailto:<?php echo e($client->email); ?>" style="color: black; text-decoration: bold;">
                        <i class="fa-regular fa-envelope"></i> <?php echo e($client->email); ?>

                    </a><br>
                    <span class="text-muted"><i class="fa-solid fa-phone"></i> <?php echo e($client->telephone); ?></span>
                </td>
                <td style="text-align: center;">
                    <span class="badge-number"><?php echo e($client->projets_count ?? 0); ?></span>
                </td>
                <td>
                    <span class="status-badge <?php echo e($badgeStatut); ?>"><?php echo e($statut); ?></span>
                </td>
                <td>
<!--                     continuer d'implémenter les modifications -->
                   <button class="action-btn editBtn" title="Modifier" style="border: none; background: none; cursor: pointer;"
                        data-id="<?php echo e($client->id); ?>"
                        data-entreprise="<?php echo e($client->entreprise); ?>"
                        data-contact_nom="<?php echo e($client->contact_nom); ?>"
                        data-contact_role="<?php echo e($client->contact_role); ?>"
                        data-email="<?php echo e($client->email); ?>"
                        data-telephone="<?php echo e($client->telephone); ?>"
                        data-adresse="<?php echo e($client->adresse); ?>">
                     <i class="fa-solid fa-pen editBtn" style="color: #272727;"></i>
                    </button>
                    <form action="/clients/<?php echo e($client->id); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce client ?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="action-btn text-danger deleteBtn" title="Supprimer" style="border: none;cursor: pointer;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</tbody>
                    </table>
                </div>
            </section>

    <?php if(session('success')): ?>
        <div id="successAlert" style="background-color: #d4edda; color: #155724; padding: 15px; margin: 20px auto; border-radius: 5px; max-width: 400px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <i class="fa-solid fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>

        <script>
            setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
            }, 5000);
        </script>
    <?php endif; ?>

    <!-- modal de creation d'un client  -->
    
    <div class="modal-overlay" id="clientModal" style="display: none;"> <div class="modal-card">
            <header class="modal-header">
                <h2>Nouveau Client</h2>
                <button class="btn-close" id="btnCloseClientModal" onclick="document.getElementById('clientModal').style.display='none'">&times;</button>
            </header>

            <form class="modal-form" id="formCreateClient" method="POST" action="/clients">
                
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label>Nom de l'entreprise / Client</label>
                    <input type="text" name="entreprise" placeholder="Ex: ESIEA, Microsoft, etc." required>
                </div>

                <div class="form-row">
                    <div class="form-group flex-1">
                        <label>Nom du contact</label>
                        <input type="text" name="contact_nom" placeholder="Prénom Nom" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Fonction</label>
                        <input type="text" name="contact_role" placeholder="Ex: Responsable IT">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group flex-2">
                        <label>Adresse E-mail</label>
                        <input type="email" name="email" placeholder="contact@entreprise.com" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Téléphone</label>
                        <input type="tel" name="telephone" placeholder="06 XX XX XX XX">
                    </div>
                </div>

                <div class="form-group">
                    <label>Adresse du client</label>
                    <textarea name="adresse" rows="2" placeholder="Rue, Code Postal, Ville"></textarea>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn-cancel" id="btnCancelClientModal" onclick="document.getElementById('clientModal').style.display='none'">Annuler</button>
                    <button type="submit" class="btn-save">Ajouter le client</button>
                </footer>
            </form>
        </div>
    </div>

    
   <script src="<?php echo e(asset('js/clients.js')); ?>"></script>
    <script src="<?php echo e(asset('js/global.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/scotty/tp-web-3/tixpro-laravel/resources/views/clients/index.blade.php ENDPATH**/ ?>