<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned();
            $table->double('latitude', 9, 7);
            $table->double('longitude', 10, 7);
            $table->timestamp('gps_utc_time');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('gps_events', function (Blueprint $table) {
            $table->foreign('device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('gps_events');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
