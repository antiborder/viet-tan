<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModeToLearnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learns', function (Blueprint $table) {
            $table->double('progress_MF', 15, 8)->nullable();
            $table->String('next_mode')->nullable();
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
            $table->dropColumn('progress_MF');
            $table->dropColumn('next_mode');
        });
    }
}
