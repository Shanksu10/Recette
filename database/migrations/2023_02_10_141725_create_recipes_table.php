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
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->text('description_recipe');
            $table->text('preparation_steps');
            $table->integer('preparation_time')->length(3);
            $table->integer('cooking_time')->length(3);
            $table->integer('number_per')->length(2);
            $table->string('picture', 255);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};
