<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bots', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('ip', 50)->unique('ip');
			$table->integer('status')->default(0);
			$table->string('time', 50)->nullable();
			$table->integer('result')->nullable();
			$table->integer('life')->default(1);
			$table->integer('ban')->nullable();
			$table->integer('otk')->nullable();
			$table->integer('bot_status')->default(2);
			$table->integer('black')->nullable();
			$table->string('bandate')->nullable();
			$table->string('blacklistdate')->nullable();
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
		Schema::drop('bots');
	}

}
