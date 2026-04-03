<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    public $timestamps = false;

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id'); 
    }

// Un élément (Client/Projet/Ticket) appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    }
