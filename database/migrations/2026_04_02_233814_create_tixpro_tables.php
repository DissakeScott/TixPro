<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        // 1. On crée la table CLIENTS
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // 👈 La sécurité !
            $table->string('entreprise');
            $table->string('contact_nom')->nullable();
            $table->string('contact_role')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->timestamps();
        });

        // 2. On crée la table PROJETS
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('nom');
            $table->string('statut');
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->integer('heures_allouees')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 3. On crée la table TICKETS
     Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('projet_id')->constrained('projets')->onDelete('cascade');
            $table->string('titre'); 
            $table->string('statut')->default('A faire'); // Valeur par défaut directement en BDD !
            $table->string('priorite');
            $table->string('type'); // 👈 Le champ manquant !
            $table->float('temps_estime'); 
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        // En cas d'annulation, on supprime dans l'ordre inverse pour les clés étrangères
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('projets');
        Schema::dropIfExists('clients');
    }
};
