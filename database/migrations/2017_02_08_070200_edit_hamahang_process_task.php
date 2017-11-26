<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditHamahangProcessTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edit_tables', function(Blueprint $table)
        {

            DB::statement('ALTER TABLE `hamahang_process_task` 
					ADD COLUMN `edit_permission_type` int NOT NULL DEFAULT 1,
					ADD COLUMN `observation_permission_type` int NOT NULL DEFAULT 1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('Alter TABLE `hamahang_process_task` 
			 DROP COLUMN `edit_permission_type`,
			 DROP COLUMN `observation_permission_type`
			 
			');
    }
}
