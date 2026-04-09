<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Ticket;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClientPortalController
{
    /**
     * Affiche le tableau de bord du client
     */
    public function index()
    {
        // 1. On trouve la fiche Client qui correspond à l'utilisateur connecté (via son email)
        $client = Client::where('email', Auth::user()->email)->first();

        // Si l'utilisateur n'a pas de fiche client associée, on renvoie une erreur propre
        if (!$client) {
            return view('client.portal', ['projets' => [], 'ticketsAValider' => []])
                   ->withErrors("Aucune fiche client n'est associée à votre adresse e-mail.");
        }

        // 2. On récupère UNIQUEMENT ses projets
        $projets = Projet::where('client_id', $client->id)->get();

        // 3. On récupère les tickets qui attendent SA validation (Tickets facturables en attente)
        $ticketsAValider = Ticket::whereIn('projet_id', $projets->pluck('id'))
                                 ->where('statut', 'À valider')
                                 ->get();

        return view('client.portal', compact('projets', 'ticketsAValider'));
    }

    /**
     * Permet au client d'accepter ou de refuser un ticket
     */
    public function validerTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Sécurité : on s'assure que c'est bien 'accepter' ou 'refuser'
        $request->validate(['action' => 'required|in:accepter,refuser']);

        if ($request->action === 'accepter') {
            $ticket->statut = 'Validé';
            $message = "Vous avez accepté le ticket facturable.";
        } else {
            $ticket->statut = 'Refusé';
            $message = "Vous avez refusé le ticket. L'agence va vous recontacter.";
        }

        $ticket->save();

        return back()->with('success', $message);
    }
}
