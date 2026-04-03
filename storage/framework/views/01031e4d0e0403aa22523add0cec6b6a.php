<?php $__env->startSection('title', 'Tableau de bord - TixPro'); ?>

<?php $__env->startSection('content'); ?>
    <section class="dashboard-content">
        
        <div class="welcome-banner">
            <div>
                <h1>Bonjour, <?php echo e(Auth::user()->name); ?> ! 👋</h1>
                <p>Voici un résumé de votre activité et des tâches en cours aujourd'hui.</p>
            </div>
            <a href="/tickets" class="btn-primary-action"><i class="fa-solid fa-plus"></i> Nouveau Ticket</a>
        </div>

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon blue"><i class="fa-solid fa-building"></i></div>
                <div class="kpi-info">
                    <h3><?php echo e($stats['total_clients']); ?></h3>
                    <p>Clients inscrits</p>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon purple"><i class="fa-solid fa-folder-open"></i></div>
                <div class="kpi-info">
                    <h3><?php echo e($stats['total_projets']); ?></h3>
                    <p>Projets en cours</p>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon orange"><i class="fa-solid fa-ticket"></i></div>
                <div class="kpi-info">
                    <h3><?php echo e($stats['tickets_ouverts']); ?></h3>
                    <p>Tickets en attente</p>
                </div>
            </div>
        </div>

        <div class="recent-activity-section">
            <h2><i class="fa-solid fa-bolt"></i> Activité récente</h2>
            <div class="recent-tickets-list">
                
                <?php if($derniers_tickets->isEmpty()): ?>
                    <p class="empty-state">Aucun ticket pour le moment.</p>
                <?php else: ?>
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Projet</th>
                                <th>Priorité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $derniers_tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Détermination de la couleur du badge
                                    $badgeClass = 'badge-moyenne';
                                    if($ticket->priorite == 'Haute') $badgeClass = 'badge-haute';
                                    if($ticket->priorite == 'Faible') $badgeClass = 'badge-faible';
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo e($ticket->titre); ?></td>
                                    
                                    <td class="text-gray"><?php echo e($ticket->projet->nom ?? 'N/A'); ?></td>
                                    
                                    <td><span class="status-badge <?php echo e($badgeClass); ?>"><?php echo e($ticket->priorite); ?></span></td>
                                    <td><a href="/tickets" class="btn-view-small">Voir</a></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/scotty/tp-web-3/tixpro-laravel/resources/views/dashboard/index.blade.php ENDPATH**/ ?>