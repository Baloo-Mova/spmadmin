<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmtpfindpieceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('smtpfindpiece', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('email')->nullable();
			$table->string('smtp')->nullable();
			$table->string('port')->nullable();
			$table->string('pass')->nullable();
			$table->integer('isget')->nullable()->default(0);
			$table->string('time')->nullable()->default('');
			$table->integer('botid')->nullable();
			$table->string('emailpas');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('smtpfindpiece');
	}

}
