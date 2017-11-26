<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContextTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('context', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->integer('pid');
			$table->string('ashape', 64);
			$table->string('eshape', 64);
			$table->string('pshape', 64);
			$table->string('apronounce', 64);
			$table->string('epronounce', 64);
			$table->string('ppronounce', 64);
			$table->string('aliteral', 64);
			$table->string('eliteral', 64);
			$table->string('pliteral', 64);
			$table->string('asynonym', 64);
			$table->string('esynonym', 64);
			$table->string('psynonym', 64);
			$table->longText('definition');
			$table->longText('description');
			$table->string('related', 64);
			$table->longText('comparative');
			$table->string('synonym', 64);
			$table->string('descrip');
			$table->binary('workflow', 1);
		    $table->timestamps();
            $table->softDeletes();
        });
		DB::statement('ALTER TABLE `context` 
			MODIFY `workflow` BINARY DEFAULT 0;');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('context');
	}

}
