<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('trackings');

        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->integer('age')->default(0);
            $table->string('gender')->default(0);
            $table->float('genderProbability')->default(0);
            $table->float('angry')->default(0);
            $table->float('disgusted')->default(0);
            $table->float('fearful')->default(0);
            $table->float('happy')->default(0);
            $table->float('neutral')->default(0);
            $table->float('sad')->default(0);
            $table->float('surprised')->default(0);
            $table->string('state')->default(0);
            $table->float('currentTime')->default(0);
            $table->ipAddress('ip')->nullable();
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
        Schema::dropIfExists('trackings');
    }
}
