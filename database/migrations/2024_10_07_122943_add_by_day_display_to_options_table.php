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
        Schema::table('options', function (Blueprint $table) {
            $table->boolean('by_day_display')->default(true)->after('preselected');
        });
    }
    
    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('by_day_display');
        });
    }
    
};
