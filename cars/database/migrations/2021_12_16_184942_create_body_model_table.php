<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodyModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_type_model', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')
                ->references('id')
                ->on('models')
                ->onDelete('cascade');
            
            $table->unsignedBigInteger('body_type_id');
            $table->foreign('body_type_id')
                ->references('id')
                ->on('body_types')
                ->onDelete('cascade'); 
            $table->primary(['model_id', 'body_type_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('body_model');
    }
}
