<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController 
{
    public function index()
    {
        $clients = \App\Models\Client::all();
        // recuperer tous les clients de la base de données
        return view('clients.index', compact('clients'));
        //afficher la vue clients/index.blade.php en lui passant la variable $clients
    
     }

public function store(Request $request)
    {
     $request->validate([
            'entreprise' => 'required|string|max:255',
            'contact_nom' => 'required|string|max:255',
            'email' => 'required|email',
           
        ]);

        
        $client = new Client();
        $client->entreprise = $request->entreprise;
        $client->contact_nom = $request->contact_nom;
        $client->contact_role = $request->contact_role;
        $client->email = $request->email;
        $client->telephone = $request->telephone;
        $client->adresse = $request->adresse;
        
        
        $client->save();

        // 4. On redirige vers la liste avec un petit message flash de succès
        return redirect('/clients')->with('success', 'Le client a été ajouté avec succès !');
    }

    // SUPPRIMER UN CLIENT
    public function destroy($id)
    {
        $client = Client::findOrFail($id); // Cherche le client ou renvoie une erreur 404
        $client->delete(); // Supprime de la base de données

        return redirect('/clients')->with('success', 'Le client a été supprimé avec succès.');
    }

    // AFFICHER LA PAGE DE MODIFICATION
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        // 1. On valide les nouvelles données exactement comme pour la création
        $request->validate([
            'entreprise' => 'required|string|max:255',
            'contact_nom' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        // 2. On retrouve le client concerné
        $client = Client::findOrFail($id);

        // 3. On écrase ses anciennes valeurs avec les nouvelles tapées dans le formulaire
        $client->entreprise = $request->entreprise;
        $client->contact_nom = $request->contact_nom;
        $client->contact_role = $request->contact_role;
        $client->email = $request->email;
        $client->telephone = $request->telephone;
        $client->adresse = $request->adresse;
        
        // 4. On sauvegarde et on redirige avec un message de succès !
        $client->save();

        return redirect('/clients')->with('success', 'Les informations du client ont été mises à jour !');
    }

}
