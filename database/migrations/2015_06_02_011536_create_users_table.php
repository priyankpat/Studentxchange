<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('xchange_id');
			$table->string('username')->unique();
			$table->string('fullname');
			$table->string('email');
			$table->text('password');
			$table->string('role');
			$table->tinyInteger('activated')->default(0);
			$table->timestamps();
			//$table->primary('xchange_id');
			$table->integer('institution_id')->unsigned()->default(1);
			$table->foreign('institution_id')->references('id')->on('institution')
				  ->onDelete('restrict')->onUpdate('cascade');
			$table->string('confirmation_code')->nullable();
			$table->rememberToken();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('users');
	}

}
