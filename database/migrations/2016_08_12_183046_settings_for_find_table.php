<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsForFindTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('find_settings',function(Blueprint $table) {
            $table->integer('id', true);
            $table->integer('threads')->default(0);
            $table->integer('count_emails')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('find_settings');
    }
}
