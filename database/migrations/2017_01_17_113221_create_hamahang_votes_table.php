<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangVotesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_votes', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();

            $table->integer('uid')->default(0)->unsigned();
            $table->string('target_table', 255)->nullable();
            $table->integer('target_id')->default(0);
            $table->integer('type')->default(0);

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
        Schema::dropIfExists('hamahang_votes');
    }

}
