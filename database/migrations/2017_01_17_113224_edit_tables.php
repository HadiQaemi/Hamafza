<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('edit_tables', function(Blueprint $table)
        {
            // ----------------- ADD COLUMN
			
				DB::statement('ALTER TABLE `hamahang_process_task` 
					ADD COLUMN `process_id` int NULL');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Schema::dropIfExists('edit_tables');
		// ------------------------ DELETE COLUMN
		
			 DB::statement('Alter TABLE `hamahang_process_task` 
			 DROP COLUMN `process_id`
			');
	}

}