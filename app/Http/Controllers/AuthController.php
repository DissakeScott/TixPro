<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
   
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. On vérifie que les champs sont remplis
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. On tente la connexion (on relie 'mot_de_passe' de la BDD au champ 'password' du formulaire)
        $credentials = [
    'email' => $request->email,
    'password' => $request->password // <-- Le mot magique que Laravel attend !
];

        // Auth::attempt va automatiquement hacher le mot de passe et le comparer avec la BDD
        if (Auth::attempt($credentials)) {
            // Connexion réussie ! On regénère la session pour la sécurité
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }

        // Si ça échoue, on renvoie sur la page avec une erreur
        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ]);
    }

  
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}