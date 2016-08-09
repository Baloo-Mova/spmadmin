<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmtpfindTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('smtpfind', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('isget')->nullable()->default(0);
			$table->string('time')->nullable()->default('');
			$table->integer('botid')->nullable();
			$table->string('emailpas');

            $table->index('emailpas');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('smtpfind');
	}

}
