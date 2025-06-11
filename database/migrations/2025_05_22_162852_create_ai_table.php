<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAiTable extends Migration {

	public function up()
	{
		Schema::create('ai', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('message', 10);
			$table->string('date', 35);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('ai');
	}
}