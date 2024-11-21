<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUserIdForeignInReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Supprimez la contrainte existante
            $table->dropForeign(['user_id']);
            
            // Ajoutez une nouvelle contrainte avec ON DELETE CASCADE
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Supprimez la contrainte avec ON DELETE CASCADE
            $table->dropForeign(['user_id']);
            
            // Rétablissez la contrainte sans ON DELETE CASCADE
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }
}
