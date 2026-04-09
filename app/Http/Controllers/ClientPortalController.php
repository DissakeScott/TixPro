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
        // 1. On récupère le ticket
        $ticket = Ticket::findOrFail($id);

        // (Optionnel mais recommandé) Sécurité : on vérifie que le ticket appartient bien à un projet de ce client
        // if ($ticket->projet->client_id !== Auth::id()) { abort(403); }

        // 2. On lit l'action envoyée par le bouton (accepter ou refuser)
        $action = $request->input('action');

        // 3. La logique métier
        if ($action === 'accepter') {
            $ticket->statut = 'Validé';
            $message = "Le ticket '{$ticket->titre}' a été accepté. Notre équipe va s'en charger !";
        } elseif ($action === 'refuser') {
            $ticket->statut = 'Refusé';
            $message = "Le ticket '{$ticket->titre}' a été refusé et annulé.";
        } else {
            return back()->withErrors(['Erreur d\'action.']);
        }

        // 4. On sauvegarde en base de données
        $ticket->save();

        // 5. On renvoie le client sur son portail avec un petit message de confirmation
        return back()->with('success', $message);
    }
}
