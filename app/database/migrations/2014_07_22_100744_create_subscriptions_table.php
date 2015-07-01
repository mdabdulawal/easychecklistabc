<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function($table){
			$table->increments('id');
			$table->integer('user_id');
			$table->string('transaction_id', 100);
			$table->float('amount');
			$table->string('user_email', 120);
			$table->string('currency', 20);
			$table->string('card_type', 25);
			$table->string('last4digit', 4);
			$table->string('captured', 32);
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
		Schema::drop('subscriptions');
	}

}
