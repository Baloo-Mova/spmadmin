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
			$table->text('thread_count')->nullable();
			$table->text('emails_from_server')->nullable();
			$table->boolean('send_attach')->default(0);
			$table->text('x_mailer')->nullable();
			$table->text('attach_name_macros')->nullable();
			$table->text('macros_two')->nullable();
			$table->text('smtp_count')->nullable();
            $table->text('message_theme')->nullable();
            $table->text('message_text')->nullable();
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
