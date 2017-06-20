<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices_groups', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('group_id')->unsigned();
            $table->integer('device_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('devices_groups', function(Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('groups');

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
        Schema::drop('devices_groups');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
