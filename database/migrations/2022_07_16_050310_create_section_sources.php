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
        Schema::create('section_sources', function (Blueprint $table) {
            $table->id('id');

            $table->bigInteger('basic_id')->unsigned();
            $table->foreign('basic_id')->references('id')->on('section_basics');

            // $table->mediumInteger('location')->nullable();
            $table->string('path', 2048);
            $table->string('extension')->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();

            $table->string('tracking', 50);
            $table->tinyInteger('restriction')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
