<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('author_id')->unsigned()->nullable();
            $table->longText('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->longText('web_url')->nullable();
            $table->string('published_at');
            $table->timestamps();

            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
