<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkSidebarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_sidebars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sidebar_type');
            $table->integer('sidebar_id')->unsigned();
            $table->string('source_page_id');
            $table->timestamps();
            $table->foreign('sidebar_id')->references('id')->on('sidebars');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_sidebars');
    }
}
