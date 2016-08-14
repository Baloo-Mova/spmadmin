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
			$table->integer('isget')->nullable()->default(0)->index();
			$table->string('time',30)->nullable()->default('')->index();
			$table->integer('botid')->nullable();
			$table->string('emailpas',50)->index();
            $table->string('status',100)->nullable()->index();
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
