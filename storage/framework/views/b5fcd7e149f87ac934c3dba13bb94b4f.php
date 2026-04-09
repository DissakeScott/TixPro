<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - TixPro</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/portal.css')); ?>">
    
</head>
<body>

    <header class="client-header">
        <div class="header-logo">
            <i class="fa-solid fa-layer-group"></i> TixPro
            <span>Espace Client</span>
        </div>

        <div class="user-menu-container">
            <div class="user-trigger" onclick="toggleDropdown()">
                <div class="user-avatar">
                    <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                </div>
                <span class="user-name"><?php echo e(Auth::user()->name); ?></span>
                <i class="fa-solid fa-chevron-down" style="font-size: 0.8rem;"></i>
            </div>

            <div class="dropdown-menu" id="userDropdown">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </header>


    <div class="portal-container" style="margin-top: 30px;">
        
        <h1 class="portal-title">Bienvenue sur votre Espace</h1>
        <p class="portal-subtitle">Suivez l'avancée de vos projets et validez les interventions.</p>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <?php if(count($ticketsAValider) > 0): ?>
            <div class="action-box">
                <h2><i class="fa-solid fa-triangle-exclamation"></i> Action Requise</h2>
                <p class="action-box-desc">Vous avez des tickets facturables en attente de votre validation pour facturation.</p>
                
                <div class="ticket-list">
                    <?php $__currentLoopData = $ticketsAValider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="ticket-card">
                            <div class="ticket-info">
                                <strong><?php echo e($ticket->titre); ?></strong>
                                <div class="ticket-meta">
                                    Projet: <?php echo e($ticket->projet->nom); ?> | Temps estimé: <?php echo e($ticket->temps_estime ?? 'Non spécifié'); ?> h
                                </div>
                            </div>
                            
                            <div class="action-buttons">
                                <form method="POST" action="/portail-client/tickets/<?php echo e($ticket->id); ?>/valider">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="action" value="refuser">
                                    <button type="submit" class="btn-reject">
                                        <i class="fa-solid fa-xmark"></i> Refuser
                                    </button>
                                </form>
                                
                                <form method="POST" action="/portail-client/tickets/<?php echo e($ticket->id); ?>/valider">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="action" value="accepter">
                                    <button type="submit" class="btn-accept">
                                        <i class="fa-solid fa-check"></i> Accepter
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <h2 class="section-title"><i class="fa-solid fa-folder-open"></i> Vos Projets en cours</h2>
        
        <div class="projects-grid">
            <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="project-card">
                    <div class="project-header">
                        <span class="status-badge"><?php echo e($projet->statut); ?></span>
                    </div>
                    <h3 class="project-name"><?php echo e($projet->nom); ?></h3>
                    
                    <div class="contract-label">Consommation du forfait :</div>
                    
                    <?php 
                        $pourcentage = ($projet->heures_allouees > 0) ? ($projet->heures_consommees / $projet->heures_allouees) * 100 : 0; 
                        $fillClass = $pourcentage >= 100 ? 'fill-danger' : 'fill-normal';
                    ?>
                    
                    <div class="progress-track">
                        <div class="progress-fill <?php echo e($fillClass); ?>" style="width: <?php echo e(min($pourcentage, 100)); ?>%;"></div>
                    </div>
                    
                    <div class="contract-stats">
                        <span><?php echo e($projet->heures_consommees); ?>h consommées</span>
                        <span>/ <?php echo e($projet->heures_allouees); ?>h</span>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    Aucun projet n'est actuellement associé à votre compte.
                </div>
            <?php endif; ?>
        </div>

    </div>
  <footer class="main-footer">
                <div class="footer-content">
                    <p>&copy; <?php echo e(date('Y')); ?> Tix Pro. Développé avec <i class="fa-solid fa-code"></i> par Scott Dissake.</p>
                    <div class="footer-links">
                        <a href="#">Mentions légales</a>
                        <a href="#">Support</a>
                        <span class="version-badge">Version 1.0</span>
                    </div>
                </div>
            </footer>
    <script src="<?php echo e(asset('js/portal.js')); ?>"> </script>
</body>
</html><?php /**PATH /home/scotty/tp-web-3/tixpro-laravel/resources/views/client/portal.blade.php ENDPATH**/ ?>