<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('demands', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('sn', 15)->unique();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->string('details')->nullable();
            $table->string('url')->nullable();
            $table->integer('category_id')->unsigned()->nullbale();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('deposit', 10, 2)->default(0);
            $table->boolean('is_pay')->default(0);
            $table->string('thumb')->nullable();
            $table->integer('amount')->default(1);
            $table->timestamp('expire_time')->nullable();
            $table->integer('view_count')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('ip', 10)->default(0);
            $table->boolean('is_hot')->default(0);
            $table->boolean('is_top')->default(0);
            $table->boolean('is_recommend')->default(0);
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
		Schema::drop('demands');
	}

}
