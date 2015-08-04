<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function(Blueprint $table)
		{
			$table->increments('post_id');
			$table->double('price');
			$table->string('title', 150);
			$table->string('author', 60);
			$table->string('course_code', 10);
			$table->text('course_name');
			$table->string('publisher', 150);
			$table->integer('year');
			$table->integer('views');
			$table->string('type', 15);
			$table->string('format', 15);
			$table->integer('isbn_10');
			$table->integer('isbn_13');
			$table->integer('edition');
			$table->integer('display_status');
			$table->integer('condition_rating');
			$table->integer('rank');
			$table->text('comments');
			$table->text('image_path');
			$table->text('primary_contact_name');
			$table->text('primary_contact_number');
			//$table->primary('post_id');
			$table->integer('xchange_id')->unsigned();
			$table->integer('institution_id')->unsigned();
			$table->foreign('institution_id')->references('id')->on('institution')
				  ->onDelete('restrict')->onUpdate('cascade');
		    $table->foreign('xchange_id')->references('xchange_id')->on('users')
				  ->onDelete('restrict')->onUpdate('cascade');
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
		Schema::drop('books');
	}

}
