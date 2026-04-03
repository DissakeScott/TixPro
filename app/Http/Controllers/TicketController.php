<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController
{
    // 1. AFFICHER LA PAGE DES TICKETS
    public function index()
    {

        $tickets = Ticket::with('projet')->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        
        // On récupère aussi tous les projets pour remplir la liste déroulante "<select>"
        $projets = Projet::where('user_id', Auth::id())->orderBy('nom', 'asc')->get();

        return view('tickets.index', compact('tickets', 'projets'));
    }

    
   public function store(Request $request)
    {
        
        $request->validate([
          'titre' => 'required|string|max:255',
            'projet_id' => 'required|integer', // Doit correspondre à un ID de projet
            'priorite' => 'required|string',
            'type' => 'required|string',
            'temps_estime' => 'required|numeric',
            'description' => 'required|string',

        ]);

        

       
      $ticket = new Ticket();
        $ticket->titre = $request->titre;
        $ticket->projet_id = $request->projet_id;
        $ticket->priorite = $request->priorite;
        $ticket->type = $request->type;
        $ticket->temps_estime = $request->temps_estime;
        $ticket->description = $request->description;
        
        $ticket->statut = $request->statut ?? 'A faire'; // Par défaut, le statut est "Ouvert" si non spécifié
        

        $ticket->user_id = Auth::id();
        $ticket->save();

        return redirect('/tickets')->with('success', 'Ticket créé avec succès !');
    }



    
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $projets = Projet::orderBy('nom', 'asc')->get(); // On a besoin des projets pour le menu déroulant
        
        return view('tickets.edit', compact('ticket', 'projets'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'projet_id' => 'required|integer',
            'priorite' => 'required|string',
            'type' => 'required|string',
            'temps_estime' => 'required|numeric',
           
            'description' => 'required|string',
        ]);

        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);
        $ticket->titre = $request->titre;
        $ticket->projet_id = $request->projet_id;
        $ticket->priorite = $request->priorite;
        $ticket->type = $request->type;
        $ticket->temps_estime = $request->temps_estime;
        
        $ticket->description = $request->description;
        $ticket->save();

        return redirect('/tickets')->with('success', 'Le ticket a été mis à jour !');
    }


    public function destroy($id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);
        $ticket->delete();

        return redirect('/tickets')->with('success', 'Le ticket a été supprimé.');
    }
}