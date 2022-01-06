<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_model', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')
                ->references('id')
                ->on('models')
                ->onDelete('cascade');
            
            $table->unsignedBigInteger('fuel_id');
            $table->foreign('fuel_id')
                ->references('id')
                ->on('fuels')
                ->onDelete('cascade'); 

            $table->primary(['model_id', 'fuel_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fuel_model');
    }
}
