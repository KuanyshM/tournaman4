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

            $table->string("schedule",2000);
            $table->string("rules",2000);

            $table->string("prize",500);

            $table->string("registration",500);
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
