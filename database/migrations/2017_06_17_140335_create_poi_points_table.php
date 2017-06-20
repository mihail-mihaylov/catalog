<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoiPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poi_points', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('poi_id')->unsigned();

            $table->double('latitude', 9, 7);
            $table->double('longitude', 10, 7);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('poi_points', function(Blueprint $table) {
            $table->foreign('poi_id')->references('id')->on('poi');
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
        Schema::drop('poi_points');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
