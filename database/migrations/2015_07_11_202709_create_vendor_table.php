<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('vendor');
            $table->string('ppp0_ip');
            $table->string('ram_used');
            $table->string('ram_free');
            $table->string('ptm_rx');
            $table->string('ptm_tx');
            $table->string('uptime');
            $table->string('uname');
            $table->string('loadavg');
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
        Schema::drop('system');
    }

}
