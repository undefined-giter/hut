<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyForeignKeyOnOptionReservation extends Migration
{
    public function up()
    {
        Schema::table('option_reservation', function (Blueprint $table) {
            // Supprimer d'abord la contrainte de clé étrangère existante
            $table->dropForeign(['option_id']);
            
            // Ajouter la nouvelle contrainte avec ON DELETE CASCADE
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('option_reservation', function (Blueprint $table) {
            // Si vous devez revenir en arrière, vous pouvez redéfinir la contrainte initiale
            $table->dropForeign(['option_id']);
            
            // Réajouter la contrainte d'origine (sans cascade)
            $table->foreign('option_id')->references('id')->on('options');
        });
    }
}
