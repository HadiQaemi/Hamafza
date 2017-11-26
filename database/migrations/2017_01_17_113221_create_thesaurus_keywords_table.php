<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThesaurusKeywordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('thesaurus_keywords', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('keyword_id')->unsigned()->nullable();
			$table->integer('subject_id')->unsigned()->nullable();
            $table->integer('created_by')->default(0)->unsigned();
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
		Schema::dropIfExists('thesaurus_keywords');
	}

}
