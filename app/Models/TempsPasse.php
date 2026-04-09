<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempsPasse extends Model
{
    protected $table = 'temps_passes';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'duree',
        'date_saisie',
        'commentaire'
    ];

    // Relation : Un "temps passé" appartient à un ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Relation : Un "temps passé" a été saisi par un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
