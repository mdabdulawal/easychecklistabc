<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('checklists', function($table){
			$table->increments('id');
			$table->string('title', 255);
			$table->integer('client_id');
			$table->integer('user_id');
			$table->date('start_date');
			$table->date('due_date');
			$table->string('link_to_folder', 255);
			$table->text('description');
			$table->enum('status', array('Running', 'Completed'))->default('Running');
			$table->integer('created_by');
			$table->string('organization_id', 120);
			$table->date('completed_at');	
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
		Schema::drop('checklists');
	}

}
