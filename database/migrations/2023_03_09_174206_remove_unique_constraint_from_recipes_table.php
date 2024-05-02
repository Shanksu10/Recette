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
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropUnique(['name', 'type_recipe']);
        });
    }

    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->unique(['name', 'type_recipe']);
        });
    }
};
