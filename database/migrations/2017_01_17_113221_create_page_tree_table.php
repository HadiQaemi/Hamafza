<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagetreeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_tree', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('tid')->default(0);
			$table->string('name');
			$table->integer('orders')->default(0);
			$table->integer('parent_id')->default(0)->index('parent_id');
			$table->binary('slave', 1);
			$table->binary('admin', 1);
			$table->integer('pid')->default(0);
			$table->boolean('depth')->default(0);
			$table->boolean('shpage')->default(0);
			$table->dateTime('reg_date');
			$table->integer('highid')->nullable();
			$table->longText('descr')->nullable();
			$table->integer('sid')->nullable()->default(0);
			$table->enum('showtype', array('4','3','2','1','0'))->nullable()->default('0')->comment(' توضیحات داده=1،کل صفحه=2، مشخصه ها=3، علامت گذاری ها =4');
			$table->string('prenum')->nullable();
			$table->enum('prenumselect', array('0','1'))->nullable();
			$table->longText('partoftext');
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `page_tree` 
			MODIFY `slave` BINARY DEFAULT 0,
			MODIFY `admin` BINARY DEFAULT 0;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('page_tree');
	}

}
