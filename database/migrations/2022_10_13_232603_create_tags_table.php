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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('basics_id')->unsigned();
            $table->foreign('basics_id')->references('id')->on('basics');

            $table->tinyInteger('db_name')->nullable();
            // $table->tinyInteger('db_id')->nullable();

            $table->tinyText('tag_category')->nullable();
            $table->tinyText('tag_context')->nullable();
            $table->tinyText('tag_content')->nullable();
            $table->tinyText('tag_comment')->nullable();

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
        Schema::dropIfExists('tags');
    }
};
