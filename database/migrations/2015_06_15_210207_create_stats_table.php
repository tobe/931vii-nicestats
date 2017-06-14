<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('mode');
            $table->string('vdsl2_profile');
            $table->string('tps_tc');
            $table->string('trellis');
            $table->string('line_status');
            $table->string('training_status');
            $table->text('errors');
            $table->text('raw');
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
        Schema::drop('stats');
    }

}
