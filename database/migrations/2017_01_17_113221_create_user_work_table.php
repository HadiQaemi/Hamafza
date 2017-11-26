<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserWorkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_work', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
            $table->smallInteger('province_id')->nullable()->default(null);
            $table->smallInteger('city_id')->nullable()->default(null);
            $table->string('company', 250)->nullable()->default(null);
            $table->string('section')->nullable()->default(null);
            $table->string('post', 250)->nullable()->default(null);
            $table->date('start_year')->nullable()->default(null);
            $table->date('end_year')->nullable()->default(null);
            $table->longText('comment')->nullable()->default(null);
            $table->integer('order')->unsigned()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->default(0);
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
		Schema::dropIfExists('user_work');
	}

}
