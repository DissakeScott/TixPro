<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];


    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'projet_user', 'user_id', 'projet_id');
    }

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

    
    

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}