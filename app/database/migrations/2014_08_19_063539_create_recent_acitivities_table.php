<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecentAcitivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recent_activities', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('type', 20);
			$table->string('activity', 120);
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
		Schema::drop('recent_activities');
	}

}
