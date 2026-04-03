@extends('layouts.app')

@section('title', 'Tableau de bord - TixPro')

@section('content')
    <section class="dashboard-content">
        
        <div class="welcome-banner">
            <div>
                <h1>Bonjour, {{ Auth::user()->name }} ! 👋</h1>
                <p>Voici un résumé de votre activité et des tâches en cours aujourd'hui.</p>
            </div>
            <a href="/tickets" class="btn-primary-action"><i class="fa-solid fa-plus"></i> Nouveau Ticket</a>
        </div>

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon blue"><i class="fa-solid fa-building"></i></div>
                <div class="kpi-info">
                    <h3>{{ $stats['total_clients'] }}</h3>
                    <p>Clients inscrits</p>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon purple"><i class="fa-solid fa-folder-open"></i></div>
                <div class="kpi-info">
                    <h3>{{ $stats['total_projets'] }}</h3>
                    <p>Projets en cours</p>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon orange"><i class="fa-solid fa-ticket"></i></div>
                <div class="kpi-info">
                    <h3>{{ $stats['tickets_ouverts'] }}</h3>
                    <p>Tickets en attente</p>
                </div>
            </div>
        </div>

        <div class="recent-activity-section">
            <h2><i class="fa-solid fa-bolt"></i> Activité récente</h2>
            <div class="recent-tickets-list">
                
                @if($derniers_tickets->isEmpty())
                    <p class="empty-state">Aucun ticket pour le moment.</p>
                @else
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Projet</th>
                                <th>Priorité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($derniers_tickets as $ticket)
                                @php
                                    // Détermination de la couleur du badge
                                    $badgeClass = 'badge-moyenne';
                                    if($ticket->priorite == 'Haute') $badgeClass = 'badge-haute';
                                    if($ticket->priorite == 'Faible') $badgeClass = 'badge-faible';
                                @endphp
                                <tr>
                                    <td class="fw-bold">{{ $ticket->titre }}</td>
                                    
                                    <td class="text-gray">{{ $ticket->projet->nom ?? 'N/A' }}</td>
                                    
                                    <td><span class="status-badge {{ $badgeClass }}">{{ $ticket->priorite }}</span></td>
                                    <td><a href="/tickets" class="btn-view-small">Voir</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </section>
@endsection