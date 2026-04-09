<?php

namespace App\Observers;

use App\Models\TempsPasse;

class TempsPasseObserver
{
    /**
     * Handle the TempsPasse "created" event.
     */
   public function created(TempsPasse $tempsPasse)
    {
        // 1. On retrouve le ticket concerné
        $ticket = $tempsPasse->ticket;
        
        // 2. On retrouve le projet de ce ticket
        $projet = $ticket->projet;

        if ($projet) {
            // 3. On ajoute la durée saisie aux heures consommées du projet
            $projet->heures_consommees += $tempsPasse->duree;
            $projet->save(); // On sauvegarde, et la barre de progression bougera !
        }
    }

    /**
     * Handle the TempsPasse "updated" event.
     */
    public function updated(TempsPasse $tempsPasse): void
    {
        //
    }

    /**
     * Handle the TempsPasse "deleted" event.
     */
    public function deleted(TempsPasse $tempsPasse)
    {
        $projet = $tempsPasse->ticket->projet;

        if ($projet) {
            $projet->heures_consommees -= $tempsPasse->duree;
            // Sécurité pour ne pas tomber en dessous de 0
            if ($projet->heures_consommees < 0) $projet->heures_consommees = 0; 
            $projet->save();
        }
    }

    /**
     * Handle the TempsPasse "restored" event.
     */
    public function restored(TempsPasse $tempsPasse): void
    {
        //
    }

    /**
     * Handle the TempsPasse "force deleted" event.
     */
    public function forceDeleted(TempsPasse $tempsPasse): void
    {
        //
    }
}
