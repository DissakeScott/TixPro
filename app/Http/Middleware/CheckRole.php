<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Si l'utilisateur n'est pas connecté, on le vire vers le login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;

        // 2. L'Administrateur a un passe-partout absolu
        if ($userRole === 'Administrateur') {
            return $next($request);
        }

     
       
        // 2. Si son rôle ne correspond pas au rôle exigé par la route
        if (Auth::user()->role !== $role) {
            
            // Si c'est un client qui essaie d'aller sur une page admin, on le renvoie sur son portail
            if (Auth::user()->role === 'Client') {
                return redirect('/portail-client')->withErrors('Accès refusé : Espace réservé aux collaborateurs.');
            }
            
            // Si c'est un collaborateur qui essaie d'aller sur une page client, on le renvoie au dashboard
            return redirect('/dashboard')->withErrors('Accès refusé.');
        }

        // 3. Si tout est bon, on le laisse passer !
        return $next($request);
    }
}
