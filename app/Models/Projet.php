<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    public $timestamps = false;
    protected $table = 'projets';
    protected $fillable = [
        'nom',
        'statut',
        'date_debut',
        'date_fin',
        'description',
        'client_id',
        'user_id',
        'heures_allouees',
        'heures_consommees', 
        'taux_horaire',      
    ];


    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }



// Un élément (Client/Projet/Ticket) appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Calcule automatiquement le nombre d'heures restantes sur le contrat.
     */
    public function getHeuresRestantesAttribute()
    {
        if (is_null($this->heures_allouees)) {
            return 0;
        }
        
        $restantes = $this->heures_allouees - $this->heures_consommees;
        
        // On retourne le résultat (si c'est négatif, ça veut dire qu'on a dépassé le forfait)
        return $restantes;
    }

    /**
     * Détermine l'état de l'enveloppe d'heures (pour l'affichage en couleur plus tard).
     */

    public function getEtatContratAttribute()
    {
        if (is_null($this->heures_allouees) || $this->heures_allouees == 0) {
            return 'Sans forfait';
        }

        $pourcentage = ($this->heures_consommees / $this->heures_allouees) * 100;

        if ($pourcentage >= 100) {
            return 'Épuisé'; // Le client doit payer en heures sup'
        } elseif ($pourcentage >= 80) {
            return 'Critique'; // Attention, on s'approche de la fin
        }

        return 'En cours';
    }

    }
