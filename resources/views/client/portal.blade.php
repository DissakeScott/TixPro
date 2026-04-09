@extends('layouts.app')

@section('title', 'Espace Client - TixPro')

@section('content')
<link rel="stylesheet" href="{{ asset('css/portal.css') }}">

<div class="portal-container">
    
    <h1 class="portal-title">Bienvenue sur votre Espace Client</h1>
    <p class="portal-subtitle">Suivez l'avancée de vos projets et validez les interventions.</p>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    @if(count($ticketsAValider) > 0)
        <div class="action-box">
            <h2><i class="fa-solid fa-triangle-exclamation"></i> Action Requise</h2>
            <p class="action-box-desc">Vous avez des tickets facturables en attente de votre validation pour facturation.</p>
            
            <div class="ticket-list">
                @foreach($ticketsAValider as $ticket)
                    <div class="ticket-card">
                        <div class="ticket-info">
                            <strong>{{ $ticket->titre }}</strong>
                            <div class="ticket-meta">
                                Projet: {{ $ticket->projet->nom }} | Temps passé: {{ $ticket->temps_reel ?? '0' }} h
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            <form method="POST" action="/portail-client/tickets/{{ $ticket->id }}/valider">
                                @csrf
                                <input type="hidden" name="action" value="refuser">
                                <button type="submit" class="btn-reject">
                                    <i class="fa-solid fa-xmark"></i> Refuser
                                </button>
                            </form>
                            
                            <form method="POST" action="/portail-client/tickets/{{ $ticket->id }}/valider">
                                @csrf
                                <input type="hidden" name="action" value="accepter">
                                <button type="submit" class="btn-accept">
                                    <i class="fa-solid fa-check"></i> Accepter
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <h2 class="section-title"><i class="fa-solid fa-folder-open"></i> Vos Projets en cours</h2>
    
    <div class="projects-grid">
        @forelse($projets as $projet)
            <div class="project-card">
                <div class="project-header">
                    <span class="status-badge">{{ $projet->statut }}</span>
                </div>
                <h3 class="project-name">{{ $projet->nom }}</h3>
                
                <div class="contract-label">Consommation du forfait :</div>
                
                @php 
                    $pourcentage = ($projet->heures_allouees > 0) ? ($projet->heures_consommees / $projet->heures_allouees) * 100 : 0; 
                    $fillClass = $pourcentage >= 100 ? 'fill-danger' : 'fill-normal';
                @endphp
                
                <div class="progress-track">
                    <div class="progress-fill {{ $fillClass }}" style="width: {{ min($pourcentage, 100) }}%;"></div>
                </div>
                
                <div class="contract-stats">
                    <span>{{ $projet->heures_consommees }}h consommées</span>
                    <span>/ {{ $projet->heures_allouees }}h</span>
                </div>
            </div>
        @empty
            <div class="empty-state">
                Aucun projet n'est actuellement associé à votre compte.
            </div>
        @endforelse
    </div>

</div>
@endsection 