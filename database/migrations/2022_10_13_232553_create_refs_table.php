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
        Schema::create('refs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('basic_id');
            $table->bigInteger('basic_ref');

            $table->tinyInteger('ref_db_id');
            $table->tinyInteger('ref_db_index');
            $table->tinyInteger('ref_db_heading')->nullable();

            $table->string('tracking', 50);
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
        Schema::dropIfExists('references');
    }
};
