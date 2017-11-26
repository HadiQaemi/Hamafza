<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangRewardsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_rewards', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();

            $table->integer('from_user_id')->unsigned()->default(0);
            $table->integer('to_user_id')->unsigned()->default(0);
            $table->string('target_table', 255)->nullable();
            $table->integer('target_id')->unsigned()->default(0);
            $table->integer('score')->default(0);

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
        Schema::dropIfExists('hamahang_rewards');
    }

}
