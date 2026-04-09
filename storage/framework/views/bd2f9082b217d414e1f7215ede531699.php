<?php $__env->startSection('title', 'Tickets - TixPro'); ?>

<?php $__env->startSection('content'); ?>
    <section class="tickets-view-section">
        <div class="section-header-row">
            <h2>Listes des tickets</h2>
            <button class="btn-create-ticket" id="btnOpenModal"><i class="fa-solid fa-plus"></i> Créer un ticket</button>
        </div>

        <?php if(session('success')): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <i class="fa-solid fa-check-circle"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 5px; border-left: 5px solid #dc3545;">
                <i class="fa-solid fa-triangle-exclamation"></i> <strong>Opération refusée :</strong> <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        
        <div class="filter-tabs-container">
            <button class="filter-tab active" data-filter="all">TOUS</button>
            <button class="filter-tab" data-filter="Faible">FAIBLE</button>
            <button class="filter-tab" data-filter="Moyenne">MOYENNE</button>
            <button class="filter-tab" data-filter="Haute">HAUTE</button>
            <button class="filter-tab" data-filter="Inclus">INCLUS</button>
            <button class="filter-tab" data-filter="Facturable">FACTURABLE</button>
        </div>

        <div class="tickets-grid-container" id="ticketsListContainer">

            <?php if($tickets->isEmpty()): ?>
                <div class="empty-state-grid" id="noTicketMessage">
                    <div class="empty-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                    <p>Aucun ticket trouvé.</p>
                </div>
            <?php else: ?>
                
                <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        // Logique pour les couleurs de bordure et de badges
                        $borderClass = 'border-faible';
                        $pillClass = 'bg-faible';
                        if ($ticket->priorite == 'Haute') { 
                            $borderClass = 'border-haute'; $pillClass = 'bg-haute'; 
                        } elseif ($ticket->priorite == 'Moyenne') { 
                            $borderClass = 'border-moyenne'; $pillClass = 'bg-moyenne'; 
                        }
                    ?>

                    <div class="ticket-card <?php echo e($borderClass); ?>" data-priority="<?php echo e($ticket->priorite); ?>" data-type="<?php echo e($ticket->type); ?>" data-id="<?php echo e($ticket->id); ?>">
                        
                        <div class="card-header">
                            <span class="card-project"><?php echo e($ticket->projet->nom ?? 'Projet inconnu'); ?></span>
                            <span class="priority-pill <?php echo e($pillClass); ?>"><?php echo e($ticket->priorite); ?></span>
                        </div>
                        
                        <div class="card-title"><?php echo e($ticket->titre); ?></div>
                        
                        <div class="card-meta">
                            <div class="meta-item"><i class="fa-regular fa-clock"></i> <?php echo e($ticket->temps_estime); ?>h</div>
                            <div class="meta-item"><i class="fa-solid fa-tag"></i> <?php echo e($ticket->type); ?></div>
                            <div class="meta-item"><i class="fa-solid fa-circle-user"></i> SD</div>
                        </div>
                        
                        <button class="btn-details php-btn-details" 
                                data-id="<?php echo e($ticket->id); ?>"
                                data-titre="<?php echo e($ticket->titre); ?>"
                                data-projet_id="<?php echo e($ticket->projet_id); ?>" data-projet="<?php echo e($ticket->projet->nom ?? 'Projet inconnu'); ?>" 
                                data-priorite="<?php echo e($ticket->priorite); ?>"
                                data-pill="<?php echo e($pillClass); ?>"
                                data-type="<?php echo e($ticket->type); ?>"
                                data-temps="<?php echo e($ticket->temps_estime); ?>"
                                data-statut="<?php echo e($ticket->statut); ?>" 
                                data-desc="<?php echo e($ticket->description); ?>"
                                data-collaborateur="<?php echo e($ticket->user->name ?? 'Non assigné'); ?>">
                             <i class="fa-solid fa-eye"></i> + de détails
                        </button>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </div>
    </section>


<!-- 
    modal de création d'un ticket et modal de détails d'un ticket -->

    <!-- <?php if($errors->any()): ?>
    <div style="background-color: #fee2e2; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <strong>🚨 Erreur de création :</strong>
        <ul style="margin-top: 10px; margin-bottom: 0;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?> -->

    <div class="modal-overlay" id="modalTicket" style="display: none;">
        <div class="modal-card">
            <header class="modal-header">
                <h2>Créer un nouveau Ticket</h2>
                <button class="btn-close" type="button" onclick="document.getElementById('modalTicket').style.display='none'">&times;</button>
            </header>

            <form class="modal-form" id="formCreateTicket" method="POST" action="/tickets">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label>Titre du ticket</label>
                    <input type="text" id="ticketTitle" name="titre" placeholder="Ex: Correction bug affichage mobile" required>
                </div>

                <div class="form-row">
                    <div class="form-group flex-2">
                        <label>Projet</label>
                        <select id="ticketProject" name="projet_id" required>
                            <option value="">Sélectionner un projet</option>
                            <?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->id); ?>"><?php echo e($p->nom); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group flex-1">
                        <label>Priorité</label>
                        <select id="ticketPriority" name="priorite">
                            <option value="Faible">Faible</option>
                            <option value="Moyenne">Moyenne</option>
                            <option value="Haute">Haute</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group flex-1">
                        <label>Type</label>
                        <div class="radio-group">
                            <label><input type="radio" name="type" value="Inclus" checked> Inclus</label>
                            <label><input type="radio" name="type" value="Facturable"> Facturable</label>
                        </div>
                    </div>
                    <div class="form-group flex-1">
                        <label>Temps estimé (h)</label>
                        <input type="number" id="ticketTime" name="temps_estime" placeholder="ex: 4" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description détaillée</label>
                    <textarea id="ticketDesc" name="description" rows="4" placeholder="Décrivez la demande du client..." required></textarea>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalTicket').style.display='none'">Annuler</button>
                    <button type="submit" class="btn-save">Enregistrer le ticket</button>
                </footer>
            </form>
        </div>
    </div>


        <!--    
modal de détails d'un ticket -->




    <div class="modal-overlay" id="modalTicketDetails" style="display: none;">
        <div class="modal-card">
            <header class="modal-header">
                <h2>Détails du Ticket</h2>
                <button class="btn-close" type="button" onclick="document.getElementById('modalTicketDetails').style.display='none'">&times;</button>
            </header>

            <div class="details-content">
                <div class="detail-header-group">
                    <span id="viewTicketProject" class="client-label">NOM DU PROJET</span>
                    <h3 id="viewTicketTitle">Titre du Ticket</h3>
                    <span id="viewTicketPriority" class="priority-pill">Priorité</span>
                </div>
                <hr class="divider">
               <div class="info-grid">
                    <div class="info-item">
                        <label>Type</label>
                        <p id="viewTicketType">-</p>
                    </div>
                    <div class="info-item">
                        <label>Temps Estimé</label>
                        <p id="viewTicketTime">0 h</p>
                    </div>
                    <div class="info-item">
                        <label>Collaborateur</label>
                        <p id="viewTicketCollaborator">-</p>
                    </div>
                    <div class="info-item">
                        <label>Statut Actuel</label>
                        <p id="viewTicketStatus" class="status-text" style="font-weight: bold;">-</p>
                    </div>
                </div>
                <hr class="divider">
                <div class="description-box">
                    <label>Description détaillée</label>
                    <p id="viewTicketDesc">Aucune description disponible.</p>
                </div>
                <footer class="modal-footer" style="justify-content: space-between; display: flex; width: 100%;">
                    <form id="formDeleteTicket" method="POST" action="" style="margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce ticket ? Cette action est irréversible.');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-cancel" style="color: #dc3545; border-color: #dc3545; display: flex; align-items: center; gap: 8px;" title="Supprimer ce ticket">
                            <i class="fa-solid fa-trash"></i> Supprimer
                        </button>
                    </form>

                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="btn-cancel" onclick="document.getElementById('modalTicketDetails').style.display='none'">Fermer</button>
                        <button type="button" id="btnOpenEditTicket" class="btn-save" style="background-color: #c4dbf3; color: black;">Modifier</button>
                      <button type="button" id="btnGoToSaisieTemps" class="btn-save" style="background-color: #3b82f6; color: white;">
                            <i class="fa-solid fa-clock"></i> Saisir du temps
                      </button>
                    </div>
                </footer>
            </div>
        </div>
        
    </div>


<!-- modal de modification d'un ticket -->

    <div class="modal-overlay" id="modalEditTicket" style="display: none;">
        <div class="modal-card">
            <header class="modal-header">
                <h2>Modifier le Ticket</h2>
                <button class="btn-close" type="button" onclick="document.getElementById('modalEditTicket').style.display='none'">&times;</button>
            </header>

            <form class="modal-form" id="formEditTicket" method="POST" action="">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?> <div class="form-group">
                    <label>Titre du ticket</label>
                    <input type="text" id="editTicketTitle" name="titre" required>
                </div>

                <div class="form-row">
                    <div class="form-group flex-2">
                        <label>Projet</label>
                        <select id="editTicketProject" name="projet_id" required>
                            <?php $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->id); ?>"><?php echo e($p->nom); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group flex-1">
                        <label>statut</label>
                        <select id="editTicketStatus" name="statut" required>
                            <option value="Nouveau">Nouveau</option>
                            <option value="En cours">En cours</option>
                            <option value="Terminé">À valider</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group flex-1">
                        <label>Priorité</label>
                        <select id="editTicketPriority" name="priorite">
                            <option value="Faible">Faible</option>
                            <option value="Moyenne">Moyenne</option>
                            <option value="Haute">Haute</option>
                        </select>
                    </div>
                    <div class="form-group flex-1">
                        <label>Temps estimé (h)</label>
                        <input type="number" id="editTicketTime" name="temps_estime" required>
                    </div>
                </div>

                <input type="hidden" id="editTicketType" name="type" value="Inclus">

                <div class="form-group">
                    <label>Description détaillée</label>
                    <textarea id="editTicketDesc" name="description" rows="4" required></textarea>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalEditTicket').style.display='none'">Annuler</button>
                    <button type="submit" class="btn-save">Mettre à jour</button>
                </footer>
            </form>
        </div>
    </div>

<!-- modal de saisie du temps passé sur un ticket -->

<div class="modal-overlay" id="modalSaisieTemps" style="display: none;">
        <div class="modal-card">
            <header class="modal-header">
                <h2><i class="fa-solid fa-stopwatch"></i> Saisir du temps</h2>
                <button type="button" class="btn-close" onclick="document.getElementById('modalSaisieTemps').style.display='none'">&times;</button>
            </header>
            
            <form id="formSaisieTemps" class="modal-form" method="POST" action="">
                <?php echo csrf_field(); ?>

                <div class="form-row">
                    <div class="form-group flex-1">
                        <label>Date de l'intervention</label>
                        <input type="date" name="date_saisie" value="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Durée (en heures)</label>
                        <input type="number" step="0.25" min="0.1" name="duree" placeholder="Ex: 1.5" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Qu'avez-vous fait ? (Optionnel)</label>
                    <textarea name="commentaire" rows="2" placeholder="Ex: Résolution du bug d'affichage sur mobile..."></textarea>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalSaisieTemps').style.display='none'">Annuler</button>
                    <button type="submit" class="btn-save" style="background-color: #22c55e;">Enregistrer le temps</button>
                </footer>
            </form>
        </div>
    </div>

        <script src="<?php echo e(asset('js/ticket.js')); ?>"></script>

        <script src="<?php echo e(asset('js/global.js')); ?>"></script>
        
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/scotty/tp-web-3/tixpro-laravel/resources/views/tickets/index.blade.php ENDPATH**/ ?>