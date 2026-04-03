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

        
        $stats = [
            'total_clients' => Client::where('user_id', $userId)->count(),
            
            'total_projets' => Projet::where('user_id', $userId)->count(),
            
            'tickets_ouverts' => Ticket::where('user_id', $userId)
                                       ->where('statut', '!=', 'Fermé') // ou 'Terminé' selon tes statuts
                                       ->count(),
                                       
            'tickets_total' => Ticket::where('user_id', $userId)->count()
        ];

        $derniers_tickets = Ticket::where('user_id', $userId)
                                  ->orderBy('id', 'desc')
                                  ->take(5)
                                  ->get();

        return view('dashboard.index', compact('stats', 'derniers_tickets')); 
       
    }

}