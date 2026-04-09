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

        
    $projet = Projet::findOrFail($request->projet_id);

      
        // Si le collaborateur a saisi un temps estimé, on vérifie qu'on a le budget
        if ($request->type === 'Inclus' && $request->temps_estime && $request->temps_estime > $projet->heures_restantes) {
            return back()
                ->withInput() 
                ->with('error', "Alerte Budget : Le temps estimé ({$request->temps_estime}h) dépasse les heures restantes du projet ({$projet->heures_restantes}h). Veuillez réduire l'estimation ou marquer le ticket comme facturable en supplément.");
        }
       
      $ticket = new Ticket();
        $ticket->titre = $request->titre;
        $ticket->projet_id = $request->projet_id;
        $ticket->priorite = $request->priorite;
        $ticket->type = $request->type;
        $ticket->temps_estime = $request->temps_estime;
        $ticket->description = $request->description;
        
        $ticket->statut = 'Nouveau'; // Par défaut, le statut est "Ouvert" si non spécifié
        

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
        // 1. Validation des données
        $request->validate([
            'titre' => 'required|string|max:255',
            'projet_id' => 'required|exists:projets,id', // 'exists' est plus sécurisé que 'integer'
            'priorite' => 'required|string',
            'type' => 'required|string',
            'statut' => 'required|string', // 👈 On n'oublie pas de valider le statut !
            'temps_estime' => 'nullable|numeric|min:0', // 👈 Rendu optionnel (nullable)
            'description' => 'required|string',
        ]);

        $ticket = Ticket::findOrFail($id);
        
        
        $projet = Projet::findOrFail($request->projet_id);

        if ($request->type === 'Inclus' && $request->temps_estime && $request->temps_estime > $projet->heures_restantes) {
            return back()
                ->withInput()
                ->with('error', "Alerte Budget : Le temps estimé ({$request->temps_estime}h) dépasse les heures restantes du projet ({$projet->heures_restantes}h).");
        }

        $ticket->titre = $request->titre;
        $ticket->projet_id = $request->projet_id;
        $ticket->priorite = $request->priorite;
        $ticket->type = $request->type;
        $ticket->temps_estime = $request->temps_estime;
        $ticket->description = $request->description;
        
        
        $ticket->statut = $request->statut; 
        
        $ticket->save();

        
        return back()->with('success', 'Le ticket a été mis à jour avec succès !');
    }


    public function destroy($id)
    {
        $ticket = Ticket::where('user_id', Auth::id())->findOrFail($id);
        $ticket->delete();

        return redirect('/tickets')->with('success', 'Le ticket a été supprimé.');
    }
}