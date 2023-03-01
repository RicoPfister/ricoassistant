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
        Schema::create('section_basics', function (Blueprint $table) {
            $table->id()->startingValue(1);

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->date('ref_date');
            $table->string('title', 255);
            $table->string('medium', 50);

            $table->string('tracking', 50);
            $table->tinyInteger('restriction')->default(1);
            $table->bigInteger('view_count')->default(0);

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
        Schema::dropIfExists('basics');
    }
};
