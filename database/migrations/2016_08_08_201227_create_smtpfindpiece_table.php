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
			$table->integer('isget')->nullable()->default(0);
			$table->string('time',30)->nullable()->default('');
			$table->integer('botid')->nullable();
			$table->string('emailpas')->index();
            $table->string('status')->nullable()->index();
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
