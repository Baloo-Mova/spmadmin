<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmtplistforcheckTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('smtplistforcheck', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('smtp')->nullable();
			$table->integer('botid')->nullable();
			$table->integer('isget')->nullable();
			$table->string('time')->nullable();
			$table->string('status')->nullable();
			$table->string('errmsg')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('smtplistforcheck');
	}

}
