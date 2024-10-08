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
        Schema::table('option_reservation', function (Blueprint $table) {
            $table->boolean('by_day')->default(false); // Colonne pour indiquer si l'option est par jour
        });
    }
    
    public function down()
    {
        Schema::table('option_reservation', function (Blueprint $table) {
            $table->dropColumn('by_day');
        });
    }
    
};
