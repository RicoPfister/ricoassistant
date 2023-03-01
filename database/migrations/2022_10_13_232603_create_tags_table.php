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

            $table->tinyInteger('section');
            $table->bigInteger('section_id');

            $table->bigInteger('tag_0_id');
            $table->bigInteger('tag_1_id');
            $table->bigInteger('tag_2_id');
            $table->bigInteger('tag_3_id')->nullable();

            $table->string('tracking', 50);
            $table->tinyInteger('restriction');

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
