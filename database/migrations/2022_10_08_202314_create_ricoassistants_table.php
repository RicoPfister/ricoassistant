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
        Schema::create('ricoassistants', function (Blueprint $table) {
            $table->id();
            $table->date('ref_date');
            // $table->string('category');
            $table->tinyText('author');
            $table->tinyText('title');

            $table->text('statement')->nullable();

            $table->string('timeTrackingFrom', 5)->nullable();
            $table->string('timeTrackingTo', 5)->nullable();
            $table->tinyText('timeTrackingSubCategory')->nullable();
            $table->string('timeTrackingActivity')->nullable();

            $table->tinyInteger('reference')->nullable();

            $table->text('tag')->nullable();

            $table->tinyText('producer')->nullable();
            $table->string('trader')->nullable();
            $table->decimal('price', $precision = 20, $scale = 2)->nullable();
            $table->string('currency')->nullable();
            $table->decimal('price_default_currency', $precision = 20, $scale = 2)->nullable();

            $table->tinyInteger('rating_quality')->nullable();
            $table->tinyInteger('rating_happyness')->nullable();
            $table->tinyInteger('rating_usability')->nullable();
            $table->tinyInteger('rating_developement')->nullable();
            $table->tinyInteger('rating_sustainability')->nullable();

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
        Schema::dropIfExists('ricoassistants');
    }
};
