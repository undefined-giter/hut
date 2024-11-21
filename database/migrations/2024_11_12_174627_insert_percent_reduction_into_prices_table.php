<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertPercentReductionIntoPricesTable extends Migration
{
    public function up()
    {
        DB::table('prices')->insert([
            'key' => 'percent_reduced_week',
            'value' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down()
    {
        DB::table('prices')->where('key', 'percent_reduced_week')->delete();
    }
}
