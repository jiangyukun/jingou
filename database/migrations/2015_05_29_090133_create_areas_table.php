<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ZuiHuiGou\Area;

class CreateAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('areas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('areaname',50);
			$table->integer('parent_id');
			$table->string('short_name',50);
			$table->integer('zipcode');
			$table->string('pinyin',100);
			$table->tinyInteger('level');
			$table->tinyInteger('sort');
            $table->timestamps();
		});
        // INSERT INTO Area VALUES (110000,'北京',0,'北京',NULL,NULL,1,1);

        $area = new Area;
        $area->id = 110000;
        $area->areaname = '北京';
        $area->parent_id = 0;
        $area->short_name = '北京';
        $area->level = 1;
        $area->sort = 1;
        $area->save();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('areas');
	}

}
