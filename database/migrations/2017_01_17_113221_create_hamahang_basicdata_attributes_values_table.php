<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangBasicdataAttributesValuesTable extends Migration
{

    const table = 'hamahang_basicdata_attributes_values';

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

            $table->integer('basicdata_value_id')->default(0);
            $table->integer('basicdata_attribute_id')->default(0);
            $table->text('value')->nullable();
            $table->integer('created_by')->unsigned(0);

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
