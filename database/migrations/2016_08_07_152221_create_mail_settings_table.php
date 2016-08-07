<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mail_settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('theme', 65535)->nullable();
			$table->text('message', 65535)->nullable();
			$table->text('bb', 65535)->nullable();
			$table->text('sh', 65535)->nullable();
			$table->text('from', 65535)->nullable();
			$table->text('reply', 65535)->nullable();
			$table->text('mot', 65535)->nullable();
			$table->text('kolps', 65535)->nullable();
			$table->integer('html')->default(0);
			$table->text('redirects', 65535)->nullable();
			$table->text('macros_one')->nullable();
			$table->text('macros_two', 65535)->nullable();
			$table->text('macros_try', 65535)->nullable();
			$table->text('macros1')->nullable();
			$table->text('macros2')->nullable();
			$table->text('macros3')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mail_settings');
	}

}
