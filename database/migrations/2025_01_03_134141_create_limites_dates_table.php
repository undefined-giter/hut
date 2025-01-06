<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('limites_dates', function (Blueprint $table) {
            $table->id();
            $table->date('minDate')->nullable();
            $table->date('maxDate')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('limites_dates');
    }
};
