<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSecGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sec_groups', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
			$table->string('name', 128);
			$table->longText('access');
			$table->boolean('subject_new', 1)->default(0);
			$table->boolean('subject_edit', 1)->default(0);
			$table->boolean('subject_list', 1)->default(0);
			$table->boolean('subject_del1', 1)->default(0);
			$table->boolean('subject_del2', 1)->default(0);
			$table->boolean('page_edit', 1)->default(0);
			$table->boolean('manager_edit', 1)->default(0);
			$table->boolean('edit_part', 1)->default(0);
			$table->boolean('action_add', 1)->default(0);
			$table->boolean('page_undo', 1)->default(0);
			$table->boolean('context_new', 1)->default(0);
			$table->boolean('context_edit', 1)->default(0);
			$table->boolean('context_del', 1)->default(0);
			$table->boolean('keyword_new', 1)->default(0);
			$table->boolean('keyword_edit', 1)->default(0);
			$table->boolean('keyword_del', 1)->default(0);
			$table->boolean('nap_new', 1)->default(0);
			$table->boolean('nap_edit', 1)->default(0);
			$table->boolean('nap_del', 1)->default(0);
			$table->boolean('secgroups', 1)->default(0);
			$table->boolean('usergroups', 1)->default(0);
			$table->boolean('user_change', 1)->default(0);
			$table->boolean('user_del', 1)->default(0);
			$table->boolean('user_list', 1)->default(0);
			$table->boolean('ticketr', 1)->default(0);
			$table->boolean('tickets', 1)->default(0);
			$table->integer('administrator', 1)->default(0);
			$table->integer('ticket', 1)->default(0);
			$table->enum('defualt', ['1','0'])->default('0');
			$table->longText('descr');
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
		Schema::dropIfExists('sec_groups');
	}

}
