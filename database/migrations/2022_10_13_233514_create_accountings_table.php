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
        Schema::create('accountings', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('basic_id')->unsigned();
            $table->foreign('basic_id')->references('id')->on('basics');

            $table->tinyText('accounting_producer')->nullable();
            $table->string('accounting_trader')->nullable();
            $table->decimal('accounting_price', $precision = 20, $scale = 2)->nullable();
            $table->string('accounting_currency')->nullable();
            $table->decimal('accounting_price_default_currency', $precision = 20, $scale = 2)->nullable();

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
        Schema::dropIfExists('accountings');
    }
};
