<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            // On ajoute le total des heures déjà consommées (par défaut à 0)
            $table->float('heures_consommees')->default(0)->after('heures_allouees');
            
            // On ajoute le prix de l'heure supplémentaire (ex: 85.50 €)
            $table->decimal('taux_horaire', 8, 2)->nullable()->after('heures_consommees');
        });
    }

    public function down()
    {
        Schema::table('projets', function (Blueprint $table) {
            // En cas d'annulation (rollback), on supprime ces deux colonnes
            $table->dropColumn(['heures_consommees', 'taux_horaire']);
        });
    }
};
