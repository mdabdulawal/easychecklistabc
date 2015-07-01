<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskRemindersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_reminders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('client_id');
			$table->integer('task_id');
			$table->date('notify_date');
			$table->enum('status', array('0', '1'))->default('0');
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
		Schema::drop('task_reminders');
	}

}
