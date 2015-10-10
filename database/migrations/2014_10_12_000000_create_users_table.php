<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('email')->nullable();
            $table->string('mobile')->unique();
            $table->string('telephone')->nullable();
            $table->string('password', 64);
            $table->boolean('gender')->nullable();
            $table->string('qq', 20)->nullable();
            $table->string('wangwang', 50)->nullable();
            $table->integer('credit')->default(0);
            $table->string('head_thumb')->nullable();
            $table->timestamp('last_time')->nullable();
            $table->date('birthday')->nullable();
            $table->decimal('balance', 8, 2)->default(0);
            $table->decimal('deposit', 8, 2)->default(0);
            $table->decimal('deposit_balance', 8, 2)->default(0);
            $table->string('reg_ip', 10)->default(0);
			$table->rememberToken();
			$table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
