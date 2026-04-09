<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TempsPasse;
use Illuminate\Support\Facades\Auth;

class TempsPasseController
{
    public function store(Request $request, $ticketId)
    {
        // 1. On vérifie que les données sont valides
        $request->validate([
            'duree' => 'required|numeric|min:0.1',
            'date_saisie' => 'required|date',
            'commentaire' => 'nullable|string|max:255'
        ]);

        // 2. On vérifie que le ticket existe bien
        $ticket = Ticket::findOrFail($ticketId);

        // 3. On enregistre le temps ! 
        // (Grâce à notre Observer, ça va automatiquement mettre à jour le projet 🚀)
        TempsPasse::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(), // Super important : on trace QUI a travaillé
            'duree' => $request->duree,
            'date_saisie' => $request->date_saisie,
            'commentaire' => $request->commentaire
        ]);

        return back()->with('success', 'Temps enregistré avec succès !');
    }
}
