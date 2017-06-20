<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poi', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('poi_type', ['marker', 'polygon', 'polyline', 'rectangle', 'circle']);
            $table->decimal('radius', 18, 12)->nullable();
            $table->enum('icon', ['house_parking', 'warehouse', 'shop', 'factory', 'office_building', 'service', 'gas_station']);
            $table->json('name');

            $table->softDeletes();
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
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('poi');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
