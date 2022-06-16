<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAndAddCityIdToEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('city_id')->default(0);
            $table->integer('country_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event', function (Blueprint $table) {
            //
        });
    }
}
