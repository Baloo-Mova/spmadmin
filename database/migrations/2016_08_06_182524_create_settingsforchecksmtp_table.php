<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsforchecksmtpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settingsforchecksmtp', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('threads')->nullable();
			$table->integer('countbots')->nullable();
			$table->string('mark', 55)->nullable();
			$table->integer('timeout')->nullable();
			$table->integer('includefile')->nullable();
			$table->integer('mailText')->nullable();
			$table->integer('countsmtp')->nullable();
			$table->integer('countbase')->nullable();
			$table->integer('countload')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settingsforchecksmtp');
	}

}
