<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangBasicdataAttributesTable extends Migration
{

    const table = 'hamahang_basicdata_attributes';

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

            $table->integer('basicdata_id')->default(0);
            $table->string('title', 255)->nullable();
            $table->string('target_table', 255)->nullable();
            $table->integer('target_id')->default(0);
            $table->text('description', 255)->nullable();
            $table->integer('created_by')->unsigned();

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
