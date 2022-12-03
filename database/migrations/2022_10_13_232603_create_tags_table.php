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

            $table->tinyInteger('db_name')->nullable();
            $table->bigInteger('db_id')->nullable();

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
