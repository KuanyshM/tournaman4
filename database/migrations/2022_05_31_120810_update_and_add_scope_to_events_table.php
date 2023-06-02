<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAndAddScopeToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string("venue",500)->nullable();
            $table->string("city",30)->nullable();
            $table->string("state",30)->nullable();

            $table->string("meet_links",500)->nullable();

            $table->string("address_announce",250)->nullable();

            $table->string("schedule",2000)->nullable();
            $table->string("rules",2000)->nullable();

            $table->string("prize",500)->nullable();

            $table->string("registration",500)->nullable();
            $table->integer("eventType")->default("1");






        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
}
