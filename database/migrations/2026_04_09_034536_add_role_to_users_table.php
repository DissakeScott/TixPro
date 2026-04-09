<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // On ajoute la colonne 'role'. 
            // On lui donne une valeur par défaut pour que tes utilisateurs existants (ceux de ta capture d'écran) ne fassent pas planter le système.
            $table->string('role')->default('Collaborateur')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Au cas où on veut annuler la migration
            $table->dropColumn('role'); 
        });
    }
};
