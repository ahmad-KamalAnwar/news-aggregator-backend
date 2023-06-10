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
            $table->integer('source_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('abstract');
            $table->string('web_url');
            $table->string('snippet');
            $table->string('headline_main');
            $table->string('publish_date');
            $table->string('document_type');
            $table->string('document_id');
            $table->string('document_uri');
            $table->timestamps();

            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->unique(['source_id', 'document_id']);
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
