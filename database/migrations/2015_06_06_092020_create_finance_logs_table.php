<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('finance_logs', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('demand_id', 15);
            $table->foreign('demand_id')->references('id')->on('demands')->onDelete('cascade');
            $table->decimal('amount', 10, 2)->default(0);
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
		Schema::drop('finance_logs');
	}

}
