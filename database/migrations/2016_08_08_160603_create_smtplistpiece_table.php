<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmtplistpieceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('smtplistpiece', function(Blueprint $table)
		{
            $table->integer('id', true);
            $table->string('smtp',80)->nullable()->index();
            $table->integer('botid')->nullable();
            $table->integer('isget')->nullable()->default(0)->index();
            $table->string('time',30)->nullable()->index();
            $table->string('status',100)->nullable()->index();
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
		Schema::drop('smtplistpiece');
	}

}
