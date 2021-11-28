<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntonymTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antonym', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('follower_name');
            $table->foreign('follower_name')
                ->references('name')
                ->on('words')
                ->onDelete('cascade');
            $table->string('followee_name');
            $table->foreign('followee_name')
                ->references('name')
                ->on('words')
                ->onDelete('cascade');
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
        Schema::dropIfExists('antonym');
    }
}
