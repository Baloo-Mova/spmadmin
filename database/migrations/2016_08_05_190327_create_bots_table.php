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
			$table->string('ip', 15)->unique('ip');
			$table->integer('status')->default(0);
			$table->string('time', 30)->nullable();
			$table->integer('result')->nullable();
			$table->integer('life')->default(1)->index();
			$table->integer('ban')->nullable()->index();
			$table->integer('otk')->nullable()->index();
			$table->integer('bot_status')->default(0);
			$table->integer('black')->nullable()->index();
			$table->string('bandate',30)->nullable();
			$table->string('blacklistdate',30)->nullable();
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
