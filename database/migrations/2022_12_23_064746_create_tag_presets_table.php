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
        Schema::create('tag_presets', function (Blueprint $table) {
            $table->id();
            $table->string('group_id', 50);
            $table->string('tag_category', 50);
            $table->string('tag_context', 50);
            $table->string('tracking', 50);
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
        Schema::dropIfExists('tag_presets');
    }
};
