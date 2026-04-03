<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - TixPro</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

    <div class="split-layout">
        
        <div class="left-panel">
            <img src="{{ asset('assets/register.png') }}" alt="TixPro Branding" class="left-panel-img">
        </div>

        <div class="right-panel">
            
            <div class="form-card">
                
                <div class="logo-area">
                    <img src="{{ asset('assets/ESIEA.png') }}" alt="Logo ESIEA">
                </div>

                <h1>Créer votre compte</h1>

                @if ($errors->any())
                    <div class="error-box">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="success-box">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="/register" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Nom complet</label>
                        <div class="input-full">
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Jean Dupont" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group flex-3">
                            <label>Adresse e-mail</label>
                            <div class="input-full">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="vous@exemple.fr" required>
                            </div>
                        </div>
                        
                        <div class="form-group flex-1">
                            <label>Rôle</label>
                            <div class="select-wrapper">
                                <select name="role" required>
                                    <option value="Collaborateur" {{ old('role') == 'Collaborateur' ? 'selected' : '' }}>Collaborateur</option>
                                    <option value="Client" {{ old('role') == 'Client' ? 'selected' : '' }}>Client</option>
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
</html>