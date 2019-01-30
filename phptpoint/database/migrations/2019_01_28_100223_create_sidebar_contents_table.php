<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidebarContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidebar_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sidebar_id')->unsigned();
            $table->string('destination_id')->nullable();
            $table->string('external_link_image')->nullable();
            $table->string('external_link_topic_name')->nullable();
            $table->string('external_link')->nullable();
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
        Schema::dropIfExists('sidebar_contents');
    }
}
