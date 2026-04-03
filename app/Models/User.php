<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 👈 N'oublie pas d'ajouter 'role' si tu l'as mis dans ta base de données !
    ];

    public function getInitialsAttribute()
    {
        $words = explode(' ', trim($this->name));
        $firstLetter = strtoupper(substr($words[0], 0, 1));
        
        if (count($words) > 1) {
            $lastLetter = strtoupper(substr(end($words), 0, 1));
            return $firstLetter . $lastLetter;
        }
        
     
        return $firstLetter;
    }
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function getAuthPasswordName()
    {
        return 'mot_de_passe';
    }


   
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    
    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}