<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;

use Illuminate\Http\Request;

class ProfileController
{
    // Affiche la page des paramètres
    public function edit()
    {
        return view('paramètres.parametres'); 
    }

    // Met à jour le Nom et l'Email
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // On vérifie que l'email est unique, SAUF pour l'utilisateur actuel
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Vos informations ont été mises à jour avec succès.');
    }

    // Met à jour le mot de passe
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed', // Confirmed cherche un champ 'new_password_confirmation'
        ]);

        $user = Auth::user();

        // On vérifie que l'ancien mot de passe tapé correspond bien à celui en base de données
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Votre mot de passe actuel est incorrect.']);
        }

        // Si c'est bon, on crypte et on sauvegarde le nouveau
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Votre mot de passe a été modifié de manière sécurisée.');
    }
}
