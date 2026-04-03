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
        // 1. Validation basique
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. On cherche l'utilisateur (en enlevant les potentiels espaces invisibles)
        $user = \App\Models\User::where('email', trim($request->email))->first();

        // 3. LA MÉTHODE FORTE : On vérifie le mot de passe manuellement
        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            
            
            Auth::login($user);
            
            
            $request->session()->regenerate();
            
            
            return redirect('/dashboard');
        }

        // 4. Si ça échoue, on renvoie l'erreur
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // On crypte ici !
        ]);

        // On le connecte direct après l'inscription
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Bienvenue sur TixPro, ' . $user->name . ' !');
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