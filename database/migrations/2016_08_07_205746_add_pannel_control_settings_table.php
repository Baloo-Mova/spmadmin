<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddPannelControlSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pannel_settings',function(Blueprint $table){
                $table->increments('id');
                $table->string('status',25)->nullable();
                $table->string('k',11)->nullable();
                $table->string('spam_k_name',11)->nullable();
                $table->string('_id',11)->nullable();
                $table->string('checkBlackList',25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pannel_settings');
    }
}
