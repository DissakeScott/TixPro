@extends('layouts.app')

@section('title', 'Liste des Clients - TixPro')



<!-- affichage de la liste des clients avec possibilité de créer, modifier et supprimer un client. -->

@section('content')
    <div class="section-header-row">
        <h2>Listes des clients</h2>
        <button class="btn-create-client"><i class="fa-solid fa-plus"></i> Ajouter un client</button>
    </div>
      <section class="clients-section">
                
                <div class="table-container shadow-card">
                    <table class="clients-table">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Contact</th>
                                <th>Coordonnées</th> 
                                <th style="text-align: center;">Projets actifs</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
    <tbody id="clientsListBody">
    @if($clients->isEmpty())
        <tr class="empty-state" id="noClientMessage">
            <td colspan="6">Aucun client enregistré pour le moment.</td>
        </tr>
    @else
        @foreach ($clients as $client)
            @php
                
                $statut = $client->statut ?? 'Actif'; 
                $badgeStatut = ($statut === 'Actif') ? 'badge-actif' : 'badge-inactif';
            @endphp
            <tr>
                <td>
                    <strong>{{ $client->entreprise }}</strong><br>
                    <small class="text-muted">{{ $client->adresse }}</small>
                </td>
                <td>
                    <strong>{{ $client->contact_nom }}</strong><br>
                    <span class="text-muted">{{ $client->contact_role }}</span>
                </td>
                <td>
                    <a href="mailto:{{ $client->email }}" style="color: black; text-decoration: bold;">
                        <i class="fa-regular fa-envelope"></i> {{ $client->email }}
                    </a><br>
                    <span class="text-muted"><i class="fa-solid fa-phone"></i> {{ $client->telephone }}</span>
                </td>
                <td style="text-align: center;">
                    <span class="badge-number">{{ $client->projets_count ?? 0 }}</span>
                </td>
                <td>
                    <span class="status-badge {{ $badgeStatut }}">{{ $statut }}</span>
                </td>
                <td>
<!--                     continuer d'implémenter les modifications -->
                   <button class="action-btn editBtn" title="Modifier" style="border: none; background: none; cursor: pointer;"
                        data-id="{{ $client->id }}"
                        data-entreprise="{{ $client->entreprise }}"
                        data-contact_nom="{{ $client->contact_nom }}"
                        data-contact_role="{{ $client->contact_role }}"
                        data-email="{{ $client->email }}"
                        data-telephone="{{ $client->telephone }}"
                        data-adresse="{{ $client->adresse }}">
                     <i class="fa-solid fa-pen editBtn" style="color: #272727;"></i>
                    </button>
                    <form action="/clients/{{ $client->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce client ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn text-danger deleteBtn" title="Supprimer" style="border: none;cursor: pointer;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    @endif
</tbody>
                    </table>
                </div>
            </section>

    @if(session('success'))
        <div id="successAlert" style="background-color: #d4edda; color: #155724; padding: 15px; margin: 20px auto; border-radius: 5px; max-width: 400px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>

        <script>
            setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
            }, 5000);
        </script>
    @endif

    <!-- modal de creation d'un client  -->
    
    <div class="modal-overlay" id="clientModal" style="display: none;"> <div class="modal-card">
            <header class="modal-header">
                <h2>Nouveau Client</h2>
                <button class="btn-close" id="btnCloseClientModal" onclick="document.getElementById('clientModal').style.display='none'">&times;</button>
            </header>

            <form class="modal-form" id="formCreateClient" method="POST" action="/clients">
                
                @csrf

                <div class="form-group">
                    <label>Nom de l'entreprise / Client</label>
                    <input type="text" name="entreprise" placeholder="Ex: ESIEA, Microsoft, etc." required>
                </div>

                <div class="form-row">
                    <div class="form-group flex-1">
                        <label>Nom du contact</label>
                        <input type="text" name="contact_nom" placeholder="Prénom Nom" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Fonction</label>
                        <input type="text" name="contact_role" placeholder="Ex: Responsable IT">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group flex-2">
                        <label>Adresse E-mail</label>
                        <input type="email" name="email" placeholder="contact@entreprise.com" required>
                    </div>
                    <div class="form-group flex-1">
                        <label>Téléphone</label>
                        <input type="tel" name="telephone" placeholder="06 XX XX XX XX">
                    </div>
                </div>

                <div class="form-group">
                    <label>Adresse du client</label>
                    <textarea name="adresse" rows="2" placeholder="Rue, Code Postal, Ville"></textarea>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn-cancel" id="btnCancelClientModal" onclick="document.getElementById('clientModal').style.display='none'">Annuler</button>
                    <button type="submit" class="btn-save">Ajouter le client</button>
                </footer>
            </form>
        </div>
    </div>

    
   <script src="{{ asset('js/clients.js') }}"></script>
    <script src="{{ asset('js/global.js') }}"></script>
@endsection