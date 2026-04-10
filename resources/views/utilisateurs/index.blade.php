@extends('layouts.app')

@section('content')
<div class="admin-container" style="max-width: 1000px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
        <h1 style="font-size: 1.5rem; color: #1e293b; margin: 0;">
            <i class="fa-solid fa-users-gear" style="color: #3b82f6;"></i> Gestion des Utilisateurs
        </h1>
    </div>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background-color: #f8fafc; color: #475569;">
                <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Nom</th>
                <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Email</th>
                <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Rôle</th>
                <th style="padding: 12px; border-bottom: 2px solid #e2e8f0; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($utilisateurs as $user)
            <tr style="border-bottom: 1px solid #e2e8f0;">
                <td style="padding: 12px; font-weight: bold; color: #334155;">{{ $user->name }}</td>
                <td style="padding: 12px; color: #64748b;">{{ $user->email }}</td>
                <td style="padding: 12px;">
                    @if($user->role === 'Client')
                        <span style="background-color: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: bold;">Client</span>
                    @elseif($user->role === 'Collaborateur')
                        <span style="background-color: #dcfce3; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: bold;">Collaborateur</span>
                    @else
                        <span style="background-color: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: bold;">{{ $user->role }}</span>
                    @endif
                </td>
                <td style="padding: 12px; text-align: right;">
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur définitivement ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background-color: transparent; color: #ef4444; border: 1px solid #ef4444; padding: 6px 12px; border-radius: 5px; cursor: pointer; transition: 0.2s;" onmouseover="this.style.backgroundColor='#ef4444'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ef4444';">
                            <i class="fa-solid fa-trash"></i> Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection