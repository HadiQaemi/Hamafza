<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subject_type', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('admin')->default(0);
			$table->string('name', 120);
			$table->boolean('did')->default(1);
			$table->binary('hamafza', 1);
			$table->binary('shname', 1);
			$table->boolean('priority')->default(1);
			$table->integer('manager')->default(0);
			$table->string('manager_title');
			$table->enum('manager_select', array('0','1'))->default('0');
			$table->integer('supporter')->default(0);
			$table->string('supporter_title');
			$table->enum('supporter_select', array('0','1'));
			$table->integer('supervisor')->default(0);
			$table->string('supervisor_title');
			$table->enum('supervisor_select', array('0','1'));
			$table->integer('process')->default(0);
			$table->longText('comment');
			$table->integer('orders')->default(0);
			$table->dateTime('reg_date');
			$table->dateTime('edit_date');
			$table->enum('manager_require', array('1','0'))->nullable()->default('0');
			$table->enum('supervisor_require', array('1','0'))->default('0');
			$table->enum('supporter_require', array('1','0'))->default('0');
			$table->enum('tagselect', array('0','1'))->nullable()->default('0');
			$table->enum('tagrequire', array('0','1'))->nullable()->default('0');
			$table->enum('proc_require', array('0','1'))->nullable()->default('0');
			$table->enum('proc_select', array('0','1'))->nullable()->default('0');
			$table->enum('portal_select', array('0','1'))->nullable()->default('0');
			$table->enum('portal_require', array('0','1'))->nullable()->default('0');
			$table->enum('department_select', array('0','1'))->nullable()->default('0');
			$table->enum('department_require', array('0','1'))->nullable()->default('0');
			$table->enum('ShowEdit', array('0','1'))->nullable()->default('0');
			$table->string('pretitle', 400)->nullable();
			$table->integer('viewalert')->nullable();
			$table->integer('editalert')->nullable();
			$table->integer('framework')->nullable();
			$table->string('writer_title')->nullable();
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `subject_type` 
			MODIFY `hamafza` BINARY DEFAULT 0,
			MODIFY `shname` BINARY DEFAULT 0');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('subject_type');
	}

}
