<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - TixPro</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/register.css')); ?>">
</head>
<body style="background-image: url('<?php echo e(asset('assets/background.png')); ?>'); 
             background-size: cover; 
             background-position: center; 
             background-repeat: no-repeat;">

    <div class="auth-card">
        
        <div class="logo-area">
            <img src="<?php echo e(asset('assets/ESIEA.png')); ?>" alt="TixPro Logo">
        </div>

        <h1>Inscription</h1>

        <?php if($errors->any()): ?>
            <div class="error-box">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/register" method="POST">
            <?php echo csrf_field(); ?>

            <div class="input-group">
                <i class="fa-regular fa-user icon-left"></i>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="Nom complet" required>
            </div>

            <div class="input-group">
                <i class="fa-regular fa-envelope icon-left"></i>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Adresse e-mail" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-briefcase icon-left"></i>
                <select name="role" required>
                    <option value="" disabled selected>Je suis un...</option>
                    <option value="Client">Client</option>
                    <option value="Collaborateur">Collaborateur</option>
                </select>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock icon-left"></i>
                <input type="password" name="password" id="password" placeholder="Mot de passe (8 car. min)" required>
                <i class="fa-regular fa-eye toggle-password" onclick="toggleVisibility('password', this)"></i>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-shield-check icon-left"></i>
                <input type="password" name="password_confirmation" id="password_confirm" placeholder="Confirmer le mot de passe" required>
                <i class="fa-regular fa-eye toggle-password" onclick="toggleVisibility('password_confirm', this)"></i>
            </div>

            <button type="submit" class="btn-submit">S'INSCRIRE</button>
        </form>

        <p class="login-link">
            Déjà un compte ? <a href="/login">Connectez-vous !</a>
        </p>
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