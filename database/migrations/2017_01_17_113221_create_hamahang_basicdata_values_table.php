<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangBasicdataValuesTable extends Migration
{

    const table = 'hamahang_basicdata_values';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::table, function(Blueprint $table)
        {
            $table->increments('id')->unsigned();

            $table->integer('parent_id')->default(0)->unsigned();
            $table->string('title', 255)->nullable();
            $table->string('dev_title', 255)->nullable();
            $table->text('value')->default(null);
            $table->integer('op_type')->default(0);
            $table->integer('inactive')->default(0);
            $table->string('comment', 255)->nullable();
            $table->string('dev_comment', 255)->nullable();

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
        Schema::dropIfExists(self::table);
    }

}
