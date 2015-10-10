<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('certifications', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('identity_card_front');
            $table->string('identity_card_back');
            $table->string('business_license');
            $table->boolean('is_identity')->default(0);
            $table->boolean('is_license')->default(0);
            $table->timestamp('identity_confirm_time');
            $table->timestamp('license_confirm_time');
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
		Schema::drop('certifications');
	}

}
