<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trade_logs', function(Blueprint $table)
		{
            $table->integer('id');
			$table->string('demand_sn', 15);
			$table->foreign('demand_sn')->references('sn')->on('demands')->onDelete('cascade');;
            $table->string('bid_sn', 15);
            $table->foreign('bid_sn')->references('sn')->on('bids')->onDelete('cascade');;
            $table->decimal('amount', 8, 2)->default(0);
            $table->decimal('transport_fee', 8, 2)->default(0);
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
		Schema::drop('trade_logs');
	}

}
