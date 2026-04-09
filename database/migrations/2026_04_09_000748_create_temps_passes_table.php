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
        Schema::create('temps_passes', function (Blueprint $table) {
            $table->id();
            // Le ticket sur lequel on a travaillé
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            
            // Le collaborateur qui a fait le travail
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->float('duree'); 
            $table->date('date_saisie');
            $table->string('commentaire')->nullable(); 
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temps_passes');
    }
};
