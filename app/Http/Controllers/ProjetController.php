<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Client; // On importe Client car un projet est souvent lié à un client
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // On importe Auth pour associer les projets à l'utilisateur connecté
use App\Models\User; // On importe User pour gérer les collaborateurs liés aux projets
class ProjetController


{
    public function create()
    {
        // On récupère uniquement les collaborateurs
        $collaborateurs = User::where('role', 'Collaborateur')->get();
        // (Tu as sûrement aussi $clients = User::where('role', 'Client')->get();)
        
        return view('projets.create', compact('collaborateurs')); // Ajoute tes variables habituelles
    }


 public function index()
    {
        $user = Auth::user();

        // 1. On récupère les projets
        if ($user->role === 'Administrateur') {
            $projets = Projet::with('client')->latest()->get();
        } else {
            $projets = $user->projets()->with('client')->latest()->get();
        }

        // 2. On charge les clients pour le menu déroulant du formulaire
        // (Vérifie si tu utilises le modèle Client ou User pour ça, 
        // par défaut c'est souvent Client::all() si tu as une table séparée)
        $clients = \App\Models\Client::all(); 

        // 3. On charge les collaborateurs pour les cases à cocher
        $collaborateurs = \App\Models\User::where('role', 'Collaborateur')->get();

        // 4. On envoie TOUTES les variables à la vue
        return view('projets.index', compact('projets', 'collaborateurs', 'clients'));
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
   
        if ($request->has('collaborateurs')) {
            $projet->collaborateurs()->sync($request->collaborateurs);
        }
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