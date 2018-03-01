<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table) {
			$table->increments('cat_id');
			$table->string('cat_name');
			$table->integer('category_id');
			$table->integer('parent_id');
			$table->string('locale');
			//$table->integer('lang_id')->unsigned();
			//$table->foreign('lang_id')->references('lang_id')->on('languages')->onDelete('cascade');
			$table->text('cat_description');
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
        Schema::drop('categories');
    }
}
