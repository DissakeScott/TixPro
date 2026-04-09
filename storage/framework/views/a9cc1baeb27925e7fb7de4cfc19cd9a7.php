<?php $__env->startSection('title', 'Projets - TixPro'); ?>

<?php $__env->startSection('content'); ?>
   

    <section class="projects-view-section">
        <div class="section-header-row">
            <h2>Mes Projets</h2>
            <button class="btn-add-project" id="btnOpenProjectModal"><i class="fa-solid fa-plus"></i> Nouveau Projet</button>
        </div>

        <?php if(session('success')): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <i class="fa-solid fa-check-circle"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        
        <div class="filter-tabs-container">
            <button class="filter-tab active" data-filter="all">TOUS</button>
            <button class="filter-tab" data-filter="En cours">EN COURS</button>
            <button class="filter-tab" data-filter="En attente">EN ATTENTE</button>
            <button class="filter-tab" data-filter="Terminé">TERMINÉS</button>
        </div>

        <div class="projects-grid-container" id="projectsListContainer">

            <?php if($projets->isEmpty()): ?>
                <div class="empty-state-grid" id="noProjectMessage">
                    <div class="empty-icon"><i class="fa-solid fa-folder-open"></i></div>
                    <p>Aucun projet trouvé.</p>
                </div>
            <?php else: ?>
                
                <?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        // Logique des couleurs de base
                        $borderClass = 'border-pending';
                        $badgeClass  = 'bg-pending';
                        
                        if ($project->statut === 'En cours') { 
                            $borderClass = 'border-active'; 
                            $badgeClass = 'bg-active'; 
                        } elseif ($project->statut === 'Terminé') { 
                            $borderClass = 'border-done'; 
                            $badgeClass = 'bg-done'; 
                        }

                        // Calcul pour la barre de progression (pour la modale)
                        $pourcentage = ($project->heures_allouees > 0) ? ($project->heures_consommees / $project->heures_allouees) * 100 : 0;
                        $couleurBarre = ($pourcentage >= 100) ? 'bg-danger' : (($pourcentage >= 80) ? 'bg-warning' : 'bg-success');
                    ?>

                    <div class="project-card <?php echo e($borderClass); ?>" data-status="<?php echo e($project->statut); ?>">
                        
                        <div class="card-header">
                            <span class="client-name"><?php echo e($project->client->entreprise ?? 'Client inconnu'); ?></span>
                            <span class="status-pill <?php echo e($badgeClass); ?>"><?php echo e($project->statut); ?></span>
                        </div>
                        
                        <div class="card-title"><?php echo e($project->nom); ?></div>
                        
                        <div class="card-details">
                            <div class="detail-row">
                                <i class="fa-regular fa-calendar"></i> 
                                <span>Du <?php echo e(date('d/m/Y', strtotime($project->date_debut))); ?> au <?php echo e(date('d/m/Y', strtotime($project->date_fin))); ?></span>
                            </div>
                            <div class="detail-row">
                                <i class="fa-solid fa-hourglass-half"></i> 
                                <span><strong><?php echo e($project->heures_consommees); ?>h</strong> / <?php echo e($project->heures_allouees); ?>h</span>
                            </div>
                        </div>
                        
                        <button class="btn-details php-btn-details" 
                                data-id="<?php echo e($project->id); ?>"
                                data-nom="<?php echo e($project->nom); ?>"
                                data-client_id="<?php echo e($project->client_id); ?>"
                                data-client="<?php echo e($project->client->entreprise ?? ''); ?>"
                                data-statut="<?php echo e($project->statut); ?>"
                                data-badge="<?php echo e($badgeClass); ?>"
                                data-debut="<?php echo e($project->date_debut); ?>"
                                data-fin="<?php echo e($project->date_fin); ?>"
                                data-heures="<?php echo e($project->heures_allouees); ?>"
                                data-desc="<?php echo e($project->description); ?>"
                                data-consommees="<?php echo e($project->heures_consommees); ?>"
                                data-restantes="<?php echo e($project->heures_restantes); ?>"
                                data-taux="<?php echo e($project->taux_horaire ?? '0'); ?>"
                                data-pourcentage="<?php echo e(min($pourcentage, 100)); ?>"
                                data-couleur="<?php echo e($couleurBarre); ?>">
                            <i class="fa-solid fa-eye"></i> + de détails
                        </button>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endif; ?>

        </div>
    </section>


<!-- 
    modal pour la création d'un projet (affiché lors du clic sur "Nouveau Projet") -->

    <div class="modal-overlay" id="modalProject" style="display: none;">
        <div class="modal-card">
            <header class="modal-header">
                <h2>Créer un nouveau Projet</h2>
                <button type="button" class="btn-close" onclick="document.getElementById('modalProject').style.display='none'">&times;</button>
            </header>
            
            <form class="modal-form" id="formCreateProject" method="POST" action="/projets">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Nom du projet</label>
                    <input type="text" name="nom" placeholder="Ex: Refonte Site Web" required>
                </div>
                <div class="form-row">
                    <div class="form-group flex-2">
                        <label>Client</label>
                        <select name="client_id" required>
                            <option value="">Sélectionner un client...</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c->id); ?>"><?php echo e($c->entreprise); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group flex-1">
                        <label>Statut</label>
                        <select name="statut" required>
                            <option value="En attente">En attente</option>
                            <option value="En cours">En cours</option>
                            <option value="Terminé">Terminé</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group flex-1">
                        <label>Début</label>
                        <input type="date" name="date_debut" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Fin</label>
                        <input type="date" name="date_fin" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Heures (h)</label>
                        <input type="number" name="heures_allouees" placeholder="Ex: 50" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Taux H.S (€)</label>
                        <input type="number" step="0.01" name="taux_horaire" placeholder="Ex: 85.50">
                    </div>
                </div>
                <div class="form-group">
                    <label>Description / Objectifs</label>
                    <textarea name="description" rows="3" placeholder="Description du projet..."></textarea>
                </div>
                <footer class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalProject').style.display='none'">Annuler</button>
                    <button type="submit" class="btn-save">Créer le projet</button>
                </footer>
            </form>
        </div>
    </div>


<!-- 
    modal pour les détails du projet (affiché lors du clic sur "Voir + de détails") -->

    <div class="modal-overlay" id="modalProjectDetails" style="display: none;">
        <div class="modal-card">
            <header class="modal-header">
                <h2>Détails du Projet</h2>
                <button type="button" class="btn-close" onclick="document.getElementById('modalProjectDetails').style.display='none'">&times;</button>
            </header>
            <div class="details-content">
                <div class="detail-header-group">
                    <span id="viewProjClient" class="client-label">NOM DU CLIENT</span>
                    <h3 id="viewProjTitle">Titre du Projet</h3>
                    <span id="viewProjStatus" class="status-pill">Statut</span>
                </div>
                
                <div style="display: flex; gap: 20px; margin-top: 15px;margin-bottom: 10px; font-size: 0.9rem; color: #475569;">
                    <div><i class="fa-regular fa-calendar"></i> Début: <strong id="viewProjStart">-</strong></div>
                    <div><i class="fa-regular fa-calendar-check"></i> Fin: <strong id="viewProjEnd">-</strong></div>
                </div>

                <div class="card-contrat">
                    <h4 style="margin-top: 0; margin-bottom: 10px; font-size: 1rem; color: #1e293b;"><i class="fa-solid fa-file-contract"></i> Suivi du Contrat</h4>
                    
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 5px;">
                        <span>Consommé: <strong id="viewProjConsommees">0</strong>h</span>
                        <span>Alloué: <strong id="viewProjHours">0</strong>h</span>
                    </div>
                    
                    <div class="progress-container">
                        <div id="viewProjProgressBar" class="progress-bar bg-success" style="width: 0%;"></div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-top: 8px;">
                        <span>Reste: <strong id="viewProjRestantes">0</strong>h</span>
                        <span>Taux H.S: <strong id="viewProjTaux">0</strong> €/h</span>
                    </div>
                </div>

                <div class="description-box">
                    <label>Objectifs / Description</label>
                    <p id="viewProjDesc">Aucune description disponible.</p>
                </div>

               <footer class="modal-footer" style="justify-content: space-between; display: flex; width: 100%;">
                    <form id="formDeleteProject" method="POST" action="" style="margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-cancel" style="color: #dc3545; border-color: #dc3545; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-trash"></i> Supprimer
                        </button>
                    </form>

                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="btn-cancel" onclick="document.getElementById('modalProjectDetails').style.display='none'">Fermer</button>
                        <button type="button" id="btnOpenEditProject" class="btn-save" style="background-color: #c4dbf3; color: black;">Modifier</button>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- modal pour la modification d'un projet (affiché lors du clic sur "Modifier" dans la modale de détails) -->

    <div class="modal-overlay" id="modalEditProject" style="display: none;">
        <div class="modal-card">
            <header class="modal-header">
                <h2>Modifier le Projet</h2>
                <button type="button" class="btn-close" onclick="document.getElementById('modalEditProject').style.display='none'">&times;</button>
            </header>
            
            <form class="modal-form" id="formEditProject" method="POST" action="">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?> 
                <div class="form-group">
                    <label>Nom du projet</label>
                    <input type="text" id="editProjNom" name="nom" required>
                </div>
                <div class="form-row">
                    <div class="form-group flex-2">
                        <label>Client</label>
                        <select id="editProjClient" name="client_id" required >
                            <option value="">Sélectionner un client...</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c->id); ?>"><?php echo e($c->entreprise); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group flex-1">
                        <label>Statut</label>
                        <select id="editProjStatut" name="statut" required>
                            <option value="En attente">En attente</option>
                            <option value="En cours">En cours</option>
                            <option value="Terminé">Terminé</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group flex-1">
                        <label>Début</label>
                        <input type="date" id="editProjDebut" name="date_debut" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Fin</label>
                        <input type="date" id="editProjFin" name="date_fin" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Heures (h)</label>
                        <input type="number" id="editProjHeures" name="heures_allouees" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Taux H.S (€)</label>
                        <input type="number" step="0.01" id="editProjTaux" name="taux_horaire">
                    </div>
                </div>
                <div class="form-group">
                    <label>Description / Objectifs</label>
                    <textarea id="editProjDesc" name="description" rows="3"></textarea>
                </div>
                <footer class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalEditProject').style.display='none'">Annuler</button>
                    <button type="submit" class="btn-save">Mettre à jour</button>
                </footer>
            </form>
        </div>
    </div>

    <script src="<?php echo e(asset('js/projects.js')); ?>"></script>
    <script src="<?php echo e(asset('js/global.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/scotty/tp-web-3/tixpro-laravel/resources/views/projets/index.blade.php ENDPATH**/ ?>