<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Projet;
use App\Models\Ticket;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController
{
 
public function index()
    {
        $userId = Auth::id();

        if (Auth::user()->role === 'Administrateur') {
            // 👑 L'Admin voit les stats globales du système
            $stats = [
                'total_clients' => Client::count(),
                'total_projets' => Projet::count(),
                'tickets_ouverts' => Ticket::where('statut', '!=', 'Fermé')->count(), // ou 'Terminé' selon tes statuts
                'tickets_total' => Ticket::count()
            ];

            $derniers_tickets = Ticket::orderBy('id', 'desc')->take(5)->get();
            
        } else {
            // 🧑‍💻 Les autres rôles voient uniquement leurs propres stats
            $stats = [
                'total_clients' => Client::where('user_id', $userId)->count(),
                'total_projets' => Projet::where('user_id', $userId)->count(),
                'tickets_ouverts' => Ticket::where('user_id', $userId)
                                           ->where('statut', '!=', 'Fermé')
                                           ->count(),
                'tickets_total' => Ticket::where('user_id', $userId)->count()
            ];

            $derniers_tickets = Ticket::where('user_id', $userId)
                                      ->orderBy('id', 'desc')
                                      ->take(5)
                                      ->get();
        }

        // 🚨 Le return est maintenant en dehors, il s'exécute dans TOUS les cas !
        return view('dashboard.index', compact('stats', 'derniers_tickets')); 
    }
}