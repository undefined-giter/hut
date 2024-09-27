<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->boolean('by_day')->default(false);
            $table->boolean('by_day_preselected')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('by_day');
            $table->dropColumn('by_day_preselected');
        });
    }    
};
