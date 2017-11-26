<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectTypeFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
        Schema::create('subject_type_fields', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
            $table->integer('stid')->unsigned()->default(0)->index('stid');
            $table->integer('field_id')->unsigned()->default(0);
            $table->enum('requires', array('0', '1'))->default('0');
            $table->integer('orders')->unsigned()->default(0);
            $table->string('help', 500)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('defvalue', 255)->nullable();
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
		Schema::dropIfExists('subject_type_fields');
	}

}
