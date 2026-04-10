<?php $__env->startSection('content'); ?>
<div class="admin-container" style="max-width: 1000px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
        <h1 style="font-size: 1.5rem; color: #1e293b; margin: 0;">
            <i class="fa-solid fa-users-gear" style="color: #3b82f6;"></i> Gestion des Utilisateurs
        </h1>
    </div>

    <?php if(session('success')): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background-color: #f8fafc; color: #475569;">
                <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Nom</th>
                <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Email</th>
                <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Rôle</th>
                <th style="padding: 12px; border-bottom: 2px solid #e2e8f0; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $utilisateurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="border-bottom: 1px solid #e2e8f0;">
                <td style="padding: 12px; font-weight: bold; color: #334155;"><?php echo e($user->name); ?></td>
                <td style="padding: 12px; color: #64748b;"><?php echo e($user->email); ?></td>
                <td style="padding: 12px;">
                    <?php if($user->role === 'Client'): ?>
                        <span style="background-color: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: bold;">Client</span>
                    <?php elseif($user->role === 'Collaborateur'): ?>
                        <span style="background-color: #dcfce3; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: bold;">Collaborateur</span>
                    <?php else: ?>
                        <span style="background-color: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: bold;"><?php echo e($user->role); ?></span>
                    <?php endif; ?>
                </td>
                <td style="padding: 12px; text-align: right;">
                    <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur définitivement ?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" style="background-color: transparent; color: #ef4444; border: 1px solid #ef4444; padding: 6px 12px; border-radius: 5px; cursor: pointer; transition: 0.2s;" onmouseover="this.style.backgroundColor='#ef4444'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ef4444';">
                            <i class="fa-solid fa-trash"></i> Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/scotty/tp-web-3/tixpro-laravel/resources/views/utilisateurs/index.blade.php ENDPATH**/ ?>