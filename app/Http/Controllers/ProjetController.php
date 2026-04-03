<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Client; // On importe Client car un projet est souvent lié à un client
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // On importe Auth pour associer les projets à l'utilisateur connecté

class ProjetController
{
    // 1. AFFICHER LA LISTE DES PROJETS
    public function index()
    {
        // On récupère les projets (avec les infos de leur client s'il y a une relation)
        // Si tu n'as pas de relation client dans ta table projets, on changera ça !
        $projets = Projet::where('user_id', Auth::id())
        -> orderBy('id', 'desc')
        ->get();
        
        // On récupère les clients pour la liste déroulante lors de la création d'un projet
        $clients = Client::orderBy('entreprise', 'asc')->get();

        return view('projets.index', compact('projets', 'clients'));
    }

    // 2. CRÉER UN NOUVEAU PROJET
   public function store(Request $request)
    {
        // 1. Validation de toutes tes données
        $request->validate([
            'nom' => 'required|string|max:255',
            'client_id' => 'required|integer',
            'statut' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut', // Sécurité Laravel : la fin doit être après le début !
            'heures_allouees' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // 2. Sauvegarde en base
        $projet = new Projet();
        $projet->user_id = Auth::id(); // On associe le projet à l'utilisateur connecté
        $projet->nom = $request->nom;
        $projet->client_id = $request->client_id;
        $projet->statut = $request->statut;
        $projet->date_debut = $request->date_debut;
        $projet->date_fin = $request->date_fin;
        $projet->heures_allouees = $request->heures_allouees;
        $projet->description = $request->description;
        $projet->save();

        return redirect('/projets')->with('success', 'Le projet a été créé avec succès !');
    }


    // 3. METTRE À JOUR UN PROJET (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'client_id' => 'required|integer',
            'statut' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heures_allouees' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $projet = Projet::findOrFail($id);
        $projet->nom = $request->nom;
        $projet->client_id = $request->client_id;
        $projet->statut = $request->statut;
        $projet->date_debut = $request->date_debut;
        $projet->date_fin = $request->date_fin;
        $projet->heures_allouees = $request->heures_allouees;
        $projet->description = $request->description;
        $projet->save();

        return redirect('/projets')->with('success', 'Le projet a été mis à jour avec succès !');
    }

    // 4. SUPPRIMER UN PROJET (DELETE)
    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);
        // Note : Si tu as des tickets liés à ce projet, assure-toi que ta base de données 
        // est configurée en "ON DELETE CASCADE", sinon Laravel bloquera la suppression par sécurité !
        $projet->delete();

        return redirect('/projets')->with('success', 'Le projet a été supprimé définitivement.');
    }
}