<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id');
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
			//$table->foreign('lang_id')->references('lang_id')->on('languages')->onDelete('cascade'),
			$table->string('locale');
			$table->string('name');
			$table->text('description');
			$table->string('slug');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
