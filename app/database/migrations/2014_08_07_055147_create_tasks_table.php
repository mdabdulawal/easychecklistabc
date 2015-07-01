<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function($table){
			$table->increments('id');
			$table->integer('checklist_id');
			$table->string('title', 255);
			$table->date('start_date');
			$table->date('due_date');			
			$table->integer('user_id');
			$table->string('link_to_folder', 255);
			$table->text('description');
			$table->enum('status', array('Running', 'Completed'))->default('Running');
			$table->integer('created_by');
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
		Schema::drop('tasks');
	}

}
