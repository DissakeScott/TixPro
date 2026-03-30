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
        $stats = [
            'total_clients' => Client::count(),
            'total_projets' => Projet::count(),
            
            'tickets_ouverts' => Ticket::where('statut', '!=', 'Fermé')->count(),
            'tickets_total' => Ticket::count()
        ];

            $user = Auth::user();
            $nom = $user->nom ?? 'Utilisateur';

        $derniers_tickets = Ticket::orderBy('id', 'desc')->take(5)->get();

        return view('dashboard.index', compact('stats', 'derniers_tickets','nom'));
    }

}