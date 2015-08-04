<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('housing', function(Blueprint $table)
		{
			$table->increments('post_id');
			$table->double('price');
			$table->string('address');
			$table->string('duration', 50);
			$table->text('listing_details');
			$table->text('amenities');
			$table->text('property_name');
			$table->text('property_type');
			$table->text('rental_type');
			$table->text('features');
			$table->text('description');
			$table->integer('condition_rating');
			$table->text('comments');
			$table->text('image_path');
			$table->text('primary_contact_name');
			$table->text('primary_contact_number');
			//begin admin set values
			$table->integer('views')->default(0);
			$table->integer('likes')->default(0);
			$table->integer('display_status')->default(1);
			$table->integer('rank')->default(0);
			$table->text('access_token');
			$table->integer('xchange_id')->unsigned();
			$table->integer('institution_id')->unsigned();
			$table->foreign('institution_id')->references('id')->on('institution')
				  ->onDelete('restrict')->onUpdate('cascade');
		    $table->foreign('xchange_id')->references('xchange_id')->on('users')
				  ->onDelete('restrict')->onUpdate('cascade');
			$table->softDeletes();
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
		Schema::drop('housing');
	}

}
