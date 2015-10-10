<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ZuiHuiGou\Setting;
use Illuminate\Support\Facades\DB;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('set_key');
            $table->string('set_value');
		});
        DB::table('settings')->insert(array(
            array('set_key' => 'site_name','set_value' => '最惠购'),
            array('set_key' => 'site_subhead','set_value' => '购物，就要最惠'),
            array('set_key' => 'site_url','set_value' => 'http://g.org'),
            array('set_key' => 'site_logo','set_value' => ''),
            array('set_key' => 'site_favicon','set_value' => ''),
            array('set_key' => 'site_keywords','set_value' => ''),
            array('set_key' => 'site_description','set_value' => ''),
            array('set_key' => 'service_phone','set_value' => '400-6767-670'),
            array('set_key' => 'is_close','set_value' => '0'),
            array('set_key' => 'close_info','set_value' => '')
        ));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}

}
