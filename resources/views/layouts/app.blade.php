<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TixPro - ERP')</title> 
    
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clients.css') }}">

    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">

    <link rel="stylesheet" href="{{ asset('css/tickets.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body>


    <div class="dashboard-container">
        @if(Auth::check() && Auth::user()->role !== 'Client')
   
        <aside class="sidebar">
            <div class="sidebar-top">
                <img src="{{ asset('assets/ESIEA.png') }}" alt="Logo ESIEA" class="sidebar-logo">
            </div>
            <nav class="sidebar-menu">
                <a href="/dashboard" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a href="/projets" class="menu-item {{ request()->is('projets') ? 'active' : '' }}"><i class="fa-solid fa-layer-group"></i> Mes Projets</a>
                <a href="/clients" class="menu-item {{ request()->is('clients') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Clients</a>
                <a href="/tickets" class="menu-item {{ request()->is('tickets') ? 'active' : '' }}"><i class="fa-solid fa-ticket"></i> Tickets</a>
            </nav>
          <div class="sidebar-bottom">
                <a href="/parametres" class="bottom-menu-item">
                    <i class="fa-solid fa-gear"></i> Paramètres
                </a>
                
                <form action="/logout" method="POST" style="margin: 0; width: 100%;">
                    @csrf
                    <button type="submit" class="bottom-menu-item btn-logout" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Déconnexion
                    </button>
                </form>
            </div>
        </aside>
         @endif

        <main class="main-content">
       @if(request()->is('dashboard'))
                <header class="top-header">
                    <div class="header-left">
                        <h2 class="header-title">@yield('title', 'Tableau de bord')</h2>
                        <span class="header-date"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::now()->locale('fr_FR')->isoFormat('dddd D MMMM YYYY') }}</span>
                    </div>
                    
                    <div class="header-right">
                        <button class="notification-btn" title="Notifications">
                            <i class="fa-regular fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        
                        <div class="user-profile-header">
                            <div class="user-avatar">{{ Auth::user()->initials }}</div>
                            <div class="user-info">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">{{ Auth::user()->role ?? 'Client' }}</span>
                            </div>
                        </div>
                    </div>
                </header>

            @else
                <header class="content-header">
                    <div class="search-container">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" id="globalSearchInput" style="color: black;" placeholder="     Rechercher...">
                    </div>
                    
                    <div class="header-icons">
                        <div class="notification-badge-container">
                            <i class="fa-regular fa-bell"></i>
                            <span class="badge">1</span>
                        </div>
                        <i class="fa-solid fa-gear settings-icon"></i>
                       
                        <div class="user-profile-header">
                            <div class="user-avatar">{{ Auth::user()->initials }}</div>
                            <div class="user-info">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">{{ Auth::user()->role ?? 'Client' }}</span>
                            </div>
                        </div>
                        
                        <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </div>
                </header>
            @endif

            <section class="page-content">
                @yield('content')
            </section>

            <footer class="main-footer">
                <div class="footer-content">
                    <p>&copy; {{ date('Y') }} Tix Pro. Développé avec <i class="fa-solid fa-code"></i> par Scott Dissake.</p>
                    <div class="footer-links">
                        <a href="#">Mentions légales</a>
                        <a href="#">Support</a>
                        <span class="version-badge">Version 1.0</span>
                    </div>
                </div>
            </footer>

        </main>
    </div>

    <script src="{{ asset('js/global.js') }}"></script>
</body>
</html>