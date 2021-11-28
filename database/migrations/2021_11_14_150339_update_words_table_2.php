<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWordsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->foreign('kanji1')->references('name')->on('kanjis');            
            $table->foreign('kanji2')->references('name')->on('kanjis');
            $table->foreign('kanji3')->references('name')->on('kanjis');
            $table->foreign('kanji4')->references('name')->on('kanjis');
            $table->foreign('kanji5')->references('name')->on('kanjis');
            $table->foreign('kanji6')->references('name')->on('kanjis');
            $table->foreign('kanji7')->references('name')->on('kanjis');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('words', function (Blueprint $table) {
            //
        });
    }
}
