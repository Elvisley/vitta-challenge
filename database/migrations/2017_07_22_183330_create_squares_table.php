<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSquaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_squares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("x");
            $table->integer("y");
            $table->boolean("painted")->default(false);

            $table->integer('territory_id')->unsigned();
            $table->foreign('territory_id')->references('id')->on('tb_territories');

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
        Schema::dropIfExists('tb_squares');
    }
}
