<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController
{
    
    public function index()
    {
        // On récupère tout le monde SAUF l'admin actuellement connecté
        $utilisateurs = User::where('id', '!=', Auth::id())->orderBy('role')->get();
        
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Sécurité supplémentaire
        if ($user->id === Auth::id()) {
            return back()->withErrors(['erreur' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        $user->delete();

        return back()->with('success', "L'utilisateur {$user->name} a été supprimé du système.");
    }
}
