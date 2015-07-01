<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function($table){
			$table->increments('id');
			$table->string('company_name', 120);
			$table->char('contact_name', 60);
			$table->string('email')->unique();
			$table->string('phone', 30);
			$table->string('mobile', 30);
			$table->string('address', 255);
			$table->string('photo');
			$table->integer('created_by')->default('0');
			$table->string('organization_id', 120);
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
		Schema::drop('clients');
	}

}
