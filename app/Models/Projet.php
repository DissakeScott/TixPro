<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    public $timestamps = false;
    protected $table = 'projets';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }



// Un élément (Client/Projet/Ticket) appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    }
