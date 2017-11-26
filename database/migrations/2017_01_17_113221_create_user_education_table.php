<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserEducationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_education', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
            $table->smallInteger('province_id')->nullable()->default(null);
            $table->smallInteger('city_id')->nullable()->default(null);
			$table->string('university', 255)->nullable()->default(null);
            $table->enum('grade', array('1', '2', '3', '4', '5', '6', '7'))->nullable()->default(null)->comment('1: دیپلم - 2: فوق دیپلم - 3: کارشناسی - 4: کارشناسی ارشد - 5: دکتری - 6: دکترای حرفه‌ای - 7: فوق دکتری');
			$table->string('major', 255)->nullable()->default(null);
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
		Schema::dropIfExists('user_education');
	}

}
