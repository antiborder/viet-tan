<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJpAndKanjiToWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('words', function (Blueprint $table) {

            $table->string('name0')->nullable();
            $table->string('name1')->nullable();
            $table->string('name2')->nullable();
            $table->string('name3')->nullable();
            $table->string('name4')->nullable();
            $table->string('name5')->nullable();
            $table->string('name6')->nullable();
            $table->string('name7')->nullable();

            $table->string('kanji0')->nullable();
            $table->string('kanji1')->nullable();
            $table->string('kanji2')->nullable();
            $table->string('kanji3')->nullable();
            $table->string('kanji4')->nullable();
            $table->string('kanji5')->nullable();
            $table->string('kanji6')->nullable();
            $table->string('kanji7')->nullable();

            $table->string('jp')->nullable();

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

            $table->dropColumn('name0');
            $table->dropColumn('name1');
            $table->dropColumn('name2');
            $table->dropColumn('name3');
            $table->dropColumn('name4');
            $table->dropColumn('name5');
            $table->dropColumn('name6');
            $table->dropColumn('name7');

            $table->dropColumn('kanji0');
            $table->dropColumn('kanji1');
            $table->dropColumn('kanji2');
            $table->dropColumn('kanji3');
            $table->dropColumn('kanji4');
            $table->dropColumn('kanji5');
            $table->dropColumn('kanji6');
            $table->dropColumn('kanji7');

            $table->dropColumn('jp');

        });
    }
}
