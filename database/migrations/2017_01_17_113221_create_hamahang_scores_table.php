<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangScoresTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_scores', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();

            $table->integer('uid')->unsigned()->default(0);
            $table->string('target_table', 255)->nullable();
            $table->integer('target_id')->unsigned()->default(0);
            $table->integer('type_value_id')->unsigned()->default(0);
            $table->integer('value')->default(0);

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
        Schema::dropIfExists('hamahang_scores');
    }

}
