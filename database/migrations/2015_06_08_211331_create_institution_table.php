<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institution', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->string('type', 30);
			$table->string('city', 20);
			$table->string('country', 30);
			$table->timestamps();
			//$table->primary('id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('institution');
	}

}
