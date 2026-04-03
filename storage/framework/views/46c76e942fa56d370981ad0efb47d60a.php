<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - TixPro</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/register.css')); ?>">
</head>
<body>

    <div class="split-layout">
        
        <div class="left-panel">
            <img src="<?php echo e(asset('assets/register.png')); ?>" alt="TixPro Branding" class="left-panel-img">
        </div>

        <div class="right-panel">
            
            <div class="form-card">
                
                <div class="logo-area">
                    <img src="<?php echo e(asset('assets/ESIEA.png')); ?>" alt="Logo ESIEA">
                </div>

                <h1>Créer votre compte</h1>

                <?php if($errors->any()): ?>
                    <div class="error-box">
                        <ul style="margin: 0; padding-left: 20px;">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php if(session('success')): ?>
                    <div class="success-box">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <form action="/register" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label>Nom complet</label>
                        <div class="input-full">
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="Jean Dupont" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group flex-3">
                            <label>Adresse e-mail</label>
                            <div class="input-full">
                                <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="vous@exemple.fr" required>
                            </div>
                        </div>
                        
                        <div class="form-group flex-1">
                            <label>Rôle</label>
                            <div class="select-wrapper">
                                <select name="role" required>
                                    <option value="Collaborateur" <?php echo e(old('role') == 'Collaborateur' ? 'selected' : ''); ?>>Collaborateur</option>
                                    <option value="Client" <?php echo e(old('role') == 'Client' ? 'selected' : ''); ?>>Client</option>
                                </select>
                                <i class="fa-solid fa-chevron-down custom-arrow"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group flex-1">
                            <label>Mot de passe</label>
                            <div class="input-with-action">
                                <input type="password" name="password" id="password" placeholder="8 caractères min." required>
                                <i class="fa-regular fa-eye toggle-password" onclick="toggleVisibility('password', this)"></i>
                            </div>
                        </div>
                        <div class="form-group flex-1">
                            <label>Confirmer</label>
                            <div class="input-with-action">
                                <input type="password" name="password_confirmation" id="password_confirm" placeholder="Confirmez" required>
                                <i class="fa-regular fa-eye toggle-password" onclick="toggleVisibility('password_confirm', this)"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">S'inscrire</button>
                </form>

                <p class="login-link">
                    Déjà un compte ? <a href="/login" class="connect">connectez-vous !</a>
                </p>
            </div>

        </div>

    </div>

    <script>
        function toggleVisibility(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html><?php /**PATH /home/scotty/tp-web-3/tixpro-laravel/resources/views/auth/register.blade.php ENDPATH**/ ?>