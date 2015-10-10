<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bids', function(Blueprint $table)
		{
            $table->bigIncrements('id');
            $table->string('sn', 15)->unique();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('demand_id')->unsigned();
            $table->foreign('demand_id')->references('id')->on('demands')->onDelete('cascade');
            $table->string('details')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('url')->nullable();
            $table->decimal('transport_fee', 8, 2)->default(0);
            $table->integer('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->boolean('is_win')->default(0);
            $table->timestamp('win_time');
            $table->string('ip', 10)->default(0);
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
		Schema::drop('bids');
	}

}
