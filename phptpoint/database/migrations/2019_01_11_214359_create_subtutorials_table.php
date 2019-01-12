<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtutorials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subtut_name');
            $table->integer('subtut_order')->default(0);
            $table->string('page_name');
            $table->longText('content')->nullable();
            $table->integer('tutorial_id')->nullable()->unsigned();
            $table->integer('slug_id')->nullable()->unsigned();
            $table->string('page_title')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tutorial_id')->references('id')->on('tutorials');
            $table->foreign('slug_id')->references('id')->on('slugs');
            $table->boolean('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtutorials');
    }
}
