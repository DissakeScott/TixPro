@extends('layouts.app')

@section('content')


<div class="settings-container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    
    <h1 style="margin-bottom: 30px;"><i class="fa-solid fa-gear"></i> Paramètres du compte</h1>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="settings-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px;">
        <h2 style="font-size: 1.2rem; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Informations Personnelles</h2>
        
        <form method="POST" action="{{ route('parametres.updateProfile') }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nom complet</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                @error('name') <span style="color: red; font-size: 0.85rem;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Adresse Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                @error('email') <span style="color: red; font-size: 0.85rem;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" style="background-color: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications
            </button>
        </form>
    </div>

    <div class="settings-card" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h2 style="font-size: 1.2rem; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Sécurité</h2>
        
        <form method="POST" action="{{ route('parametres.updatePassword') }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Mot de passe actuel</label>
                <input type="password" name="current_password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                @error('current_password') <span style="color: red; font-size: 0.85rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nouveau mot de passe</label>
                    <input type="password" name="new_password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    @error('new_password') <span style="color: red; font-size: 0.85rem;">{{ $message }}</span> @enderror
                </div>
                
                <div style="flex: 1;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="new_password_confirmation" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
            </div>

            <button type="submit" style="background-color: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                <i class="fa-solid fa-lock"></i> Mettre à jour le mot de passe
            </button>
        </form>
    </div>

</div>
@endsection