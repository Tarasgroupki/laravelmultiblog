<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function(Blueprint $table)
      {
        $table->increments('id')->unsigned();
		$table->integer('post_id')->unsigned();
        $table->string('name');
        $table->text('description');
        $table->string('cover_image');
		//$table->foreign('post_id')->references('product_id')->on('posts')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('albums');
    }
}
