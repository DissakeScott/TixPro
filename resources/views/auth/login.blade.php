<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - TixPro ESIEA</title>
    
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="login-container">
        <main class="login-card">
            <div class="logo-area">
                <img src="{{ asset('assets/ESIEA.png') }}" alt="Logo ESIEA" class="login-logo">
            </div>

            <h1>Connexion</h1>

            @if (session('success'))
                <div style="color: #155724; background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem; text-align: center;">
                    {{ session('success') }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="/login">
                
                @csrf
                
                @error('email')
                    <div style="color: #d9534f; background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem;">
                        {{ $message }}
                    </div>
                @enderror

                <div class="input-group">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Votre adresse e-mail" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Entrer votre mot de passe" required>
                </div>

                <div class="login-options">
                    <label class="checkbox-container">
                        <input type="checkbox" id="showPassword" onclick="togglePassword()"> Afficher le mot de passe
                    </label>
                    <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-login">CONNEXION</button>
            </form>

            <p class="footer-text">
                Pas de compte ? <a href="/register">inscrivez-vous !</a>
            </p>
        </main>
    </div>

    <script>
        function togglePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>