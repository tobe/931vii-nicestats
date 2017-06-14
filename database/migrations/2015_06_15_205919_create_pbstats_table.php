<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePbstatsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pbStats', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('line_attenuation');
            $table->string('signal_attenuation');
            $table->string('snr_margin');
            $table->string('tx_power');
            $table->string('actual_tx');
            $table->string('attainable_rate');
            $table->string('actual_rate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pbStats');
    }

}
