<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageBySubjectView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('page_by_subject', function(Blueprint $table)
        {
            
			DB::statement('CREATE VIEW `page_by_subject` AS 
				select `p`.`id` AS `pid`,`p`.`sid` AS `sid` 
				from (`pages` `p` left join `subjects` `s` 
				on((`p`.`sid` = `s`.`id`))) ;');
				
			//	DROP VIEW IF EXISTS `page_by_subject`;
			//	CREATE ALGORITHM=UNDEFINED DEFINER=`hamaf_user`@`localhost` 
			//	SQL SECURITY DEFINER  
			//	VIEW `page_by_subject` AS 
			//	select `p`.`id` AS `pid`,`p`.`sid` AS `sid` 
			//	from (`pages` `p` left join `subjects` `s` 
			//	on((`p`.`sid` = `s`.`id`))) ;
		});
	}

	public function down()
	{
		DB::statement('DROP VIEW `page_by_subject`');
	}

}