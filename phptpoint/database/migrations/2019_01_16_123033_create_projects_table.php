<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pro_name');
            $table->string('page_name');
            $table->string('pro_image')->nullable();
            $table->string('video_url')->nullable();
            $table->longText('content')->nullable();
            $table->integer('slug_id')->nullable()->unsigned();
            $table->string('page_title')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->boolean('is_paid')->default(0);
            $table->integer('price')->default(0);            
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('slug_id')->references('id')->on('slugs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
