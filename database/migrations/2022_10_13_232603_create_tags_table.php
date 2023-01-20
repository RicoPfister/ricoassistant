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

            $table->bigInteger('basic_id');

            $table->tinyInteger('section_table');
            $table->bigInteger('section_table_id');

            $table->bigInteger('tag_id')->nullable();
            $table->bigInteger('tag_table');
            $table->bigInteger('tag_table_id');

            $table->string('tracking', 50);
            $table->string('status', 1)->nullable();

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
