<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeWordsTableDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->renameColumn('body', 'detail');
        });
        Schema::table('words', function (Blueprint $table) {
            $table->text('detail')->nullable()->change();
        });
        Schema::table('words', function (Blueprint $table) {
            $table->text('jp')->nullable()->change();
        });        
        Schema::table('words', function (Blueprint $table) {
            $table->string('no_diacritic')->nullable();
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
            $table->dropColumn('no_diacritic');
        });                
        Schema::table('words', function (Blueprint $table) {
            $table->string('jp')->nullable()->change();
        });        
        Schema::table('words', function (Blueprint $table) {
            $table->text('detail')->change();
        });
        Schema::table('words', function (Blueprint $table) {
            $table->renameColumn('detail', 'body');
        });



    }
}
