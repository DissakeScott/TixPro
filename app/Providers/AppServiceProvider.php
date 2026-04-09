<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Observers\TempsPasseObserver;
use App\Models\TempsPasse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        TempsPasse::observe(TempsPasseObserver::class);
        View::composer('layouts.app', function ($view) {
            
         $nom = 'Utilisateur';
            $role = 'Rôle';

            // 1. Si un utilisateur est connecté, on récupère ses VRAIES infos
            if (Auth::check()) {
                $user = Auth::user();
                
                $prenom = $user->prenom ?? '';
                $nomFamille = $user->nom ?? '';
                
                
                $nomComplet = trim($prenom . ' ' . $nomFamille);
                
                if (!empty($nomComplet)) {
                    $nom = $nomComplet;
                }
                
                $role = $user->role ?? 'Default Role';
            }
            
            // 2. Calcul automatique des initiales (fonctionne avec le vrai nom maintenant !)
            $mots = explode(' ', trim($nom));
            $initiales = strtoupper(substr($mots[0], 0, 1) . (isset($mots[1]) ? substr($mots[1], 0, 1) : ''));
            $initialeSimple = strtoupper(substr($nom, 0, 1));

            // 3. Calcul de la date en français
            $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            $dateFr = $jours[date('w')] . ' ' . date('d') . ' ' . $mois[date('n')-1] . ' ' . date('Y');

            // 4. On injecte tout ça dans le layout HTML
            $view->with(compact('nom', 'role', 'initiales', 'initialeSimple', 'dateFr'));
        });
    }
    }

