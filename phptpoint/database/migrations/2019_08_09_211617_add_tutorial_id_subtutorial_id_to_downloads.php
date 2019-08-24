<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTutorialIdSubtutorialIdToDownloads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('downloads', function (Blueprint $table) {
            $table->integer('tutorial_id')->nullable()->unsigned();
            $table->integer('subtutorial_id')->nullable()->unsigned();
            $table->foreign('tutorial_id')->references('id')->on('tutorials');
            $table->foreign('subtutorial_id')->references('id')->on('subtutorials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('downloads', function (Blueprint $table) {
            //
        });
    }
}
