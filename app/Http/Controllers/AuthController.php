<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // 👈 INDISPENSABLE pour crypter le mot de passe
use App\Models\Client;
use App\Models\Projet;
use App\Models\Ticket;
use App\Models\User;

class AuthController 
{
    // ===================================================
    // 1. PARTIE CONNEXION 
    // ===================================================
    public function showLoginForm()
    {
        return view('auth.login');
    }
public function login(Request $request)
    {
     
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        
        $user = \App\Models\User::where('email', trim($request->email))->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            
            // On connecte l'utilisateur
            Auth::login($user);
            
            // On sécurise la session
            $request->session()->regenerate();
            
            
            if ($user->role === 'Client') {
                return redirect()->intended('/portail-client')->with('success', 'Heureux de vous revoir sur votre espace !');
            }

            // Si ce n'est pas un client (donc un Collaborateur), direction le dashboard de l'agence
            return redirect()->intended('/dashboard')->with('success', 'Bon retour parmi nous !');
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ])->onlyInput('email');
    }
    // ===================================================
    // 2. PARTIE INSCRIPTION 
    // ===================================================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validation (On ajoute le rôle avec une sécurité stricte)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Collaborateur,Client', // 👈 Sécurité : On n'accepte QUE ces deux mots
        ]);

        // 2. Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // 👈 On enregistre le rôle en BD
        ]);

        // 3. On connecte l'utilisateur
        Auth::login($user);

        // 4. Redirection Dynamique selon le rôle
        if ($user->role === 'Client') {
            return redirect('/portail-client')->with('success', 'Bienvenue sur votre espace client, ' . $user->name . ' !');
        }

        // Si ce n'est pas un client, c'est un collaborateur
        return redirect('/dashboard')->with('success', 'Bienvenue dans l\'agence TixPro, ' . $user->name . ' !');
    }

    // ===================================================
    // 3. PARTIE DÉCONNEXION 
    // ===================================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}