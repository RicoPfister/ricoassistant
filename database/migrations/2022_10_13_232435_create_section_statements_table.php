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
        Schema::create('section_statements', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('basic_id')->unsigned();
            $table->foreign('basic_id')->references('id')->on('section_basics');

            $table->text('statement');

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
        Schema::dropIfExists('statements');
    }
};
