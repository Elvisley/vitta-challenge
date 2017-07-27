<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string("uri",256);
            $table->string("request",256);
            $table->string("ip_client",30);
            $table->string("exception",256);
            $table->longText("message");
            $table->integer("code");
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
        Schema::dropIfExists('tb_logs');
    }
}
