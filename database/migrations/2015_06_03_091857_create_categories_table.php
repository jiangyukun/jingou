<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('parent_id');
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->tinyInteger('sort')->default(0);
			$table->timestamps();
		});

        DB::table('categories')->insert(array(
            array('id' => '1000', 'parent_id' => '0', 'name' => 'electronic','slug' => '家用电器', 'sort' => '0'),
            array('id' => '1001', 'parent_id' => '1000', 'name' => 'tv','slug' => '电视', 'sort' => '0'),
            array('id' => '1002', 'parent_id' => '1000', 'name' => 'refrigerator','slug' => '冰箱', 'sort' => '1'),
            array('id' => '1003', 'parent_id' => '1000', 'name' => 'washing-machine','slug' => '洗衣机', 'sort' => '2'),
            array('id' => '1004', 'parent_id' => '1000', 'name' => 'air-condition','slug' => '空调', 'sort' => '3'),
            array('id' => '2000', 'parent_id' => '0', 'name' => '3c','slug' => '3C数码', 'sort' => '1'),
            array('id' => '2001', 'parent_id' => '2000', 'name' => 'mobile-phone','slug' => '手机', 'sort' => '0'),
            array('id' => '2002', 'parent_id' => '2000', 'name' => 'computer-d','slug' => '台式机', 'sort' => '1'),
            array('id' => '2003', 'parent_id' => '2000', 'name' => 'computer-n','slug' => '笔记本电脑', 'sort' => '2'),
            array('id' => '2004', 'parent_id' => '2000', 'name' => 'computer-p','slug' => '平板电脑', 'sort' => '3'),
            array('id' => '2005', 'parent_id' => '2000', 'name' => 'computer-o','slug' => '电脑周边', 'sort' => '4'),
            array('id' => '2006', 'parent_id' => '2000', 'name' => 'projector','slug' => '投影仪', 'sort' => '8'),
            array('id' => '2007', 'parent_id' => '2000', 'name' => 'printer','slug' => '打印机', 'sort' => '9'),
        ));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('categories');
	}

}
