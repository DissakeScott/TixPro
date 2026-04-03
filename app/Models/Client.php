<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
   protected $table = 'clients';
    public $timestamps = false;


public function projets()
    {
        return $this->hasMany(Projet::class, 'client_id');
    }

// Un élément (Client/Projet/Ticket) appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           

}