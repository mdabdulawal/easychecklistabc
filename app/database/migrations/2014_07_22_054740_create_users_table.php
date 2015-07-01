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
		Schema::create('users', function($table){
			$table->increments('id');
			$table->char('first_name', 20);
			$table->char('middle_name', 20);
			$table->char('last_name', 20);
			$table->char('title', 120);
			$table->string('email')->unique();
			$table->string('password');
			$table->enum('gender', array('0','1','2','9'))->default('0');
    		/*0 = not known, 1 = male, 2 = female, 9 = not applicable.*/
			$table->string('phone', 30);
			$table->string('mobile', 30);
			$table->string('address', 255);
			$table->string('city', 50);
			$table->string('country');
			$table->text('about');
			$table->string('photo');
			$table->integer('pricing_id', 3);
			$table->enum('role', array('100','99','88','77','11'))->default('99');
			/*system_admin(100), super_admin(99), admin(88), user(77), client(11)*/
			$table->integer('created_by')->default('0');
			$table->string('organization_id', 120);
			$table->string('remember_token', 100)->nullable();
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
		Schema::drop('users');
	}

}
