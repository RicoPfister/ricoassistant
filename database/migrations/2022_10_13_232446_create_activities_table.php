<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('basic_id')->unsigned();
            $table->foreign('basic_id')->references('id')->on('basics');

            $table->string('activityFrom', 5)->nullable();
            $table->string('activityTo', 5)->nullable();
            $table->string('activityReference')->nullable();

            $table->tinyText('tracking')->nullable();

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
        Schema::dropIfExists('time_trackings');
    }
};
