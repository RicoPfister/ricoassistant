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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('basic_id')->unsigned();
            $table->foreign('basic_id')->references('id')->on('basics');

            $table->tinyInteger('rating_comparison')->nullable();
            $table->tinyInteger('rating_happiness')->nullable();
            $table->tinyInteger('rating_sadness')->nullable();
            $table->tinyInteger('rating_quality')->nullable();
            $table->tinyInteger('rating_ingenuity')->nullable();
            $table->tinyInteger('rating_originality')->nullable();
            $table->tinyInteger('rating_complexity')->nullable();
            $table->tinyInteger('rating_simplicity')->nullable();
            $table->tinyInteger('rating_usability')->nullable();
            $table->tinyInteger('rating_versatility')->nullable();
            $table->tinyInteger('rating_developement')->nullable();
            $table->tinyInteger('rating_sustainability')->nullable();

            $table->tinyText('tracking')->nullable();
            $table->tinyInteger('status')->nullable();

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
        Schema::dropIfExists('ratings');
    }
};
