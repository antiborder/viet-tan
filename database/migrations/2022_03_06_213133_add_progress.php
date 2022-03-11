<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProgress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learns', function (Blueprint $table) {
            $table->double('progress',15, 8)->nullable();
            $table->unique(['user_id', 'word_id']);
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learns', function (Blueprint $table) {
            $table->dropColumn('progress');
            $table->dropUnique(['user_id', 'word_id']);
        });
    }
}
