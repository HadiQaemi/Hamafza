<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangToolsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hamahang_tools', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('title', 500);
			$table->tinyInteger('url_type');
			$table->string('url', 500)->nullable()->default(null);
			$table->string('icon', 255)->nullable()->default(null);
			$table->integer('tools_group_id')->nullable()->default(null);
			$table->integer('available_id')->nullable()->default(null);
			$table->integer('orders')->nullable()->default(0);
            $table->enum('visible', array('0','1'))->nullable()->default('1');
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
		Schema::dropIfExists('hamahang_tools');
	}

}
