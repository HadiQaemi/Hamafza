<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangHelpSeeAlsosTable extends Migration
{

    const table = 'hamahang_help_see_alsos';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::table, function (Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('help_1_id')->default(0);
            $table->integer('help_2_id')->default(0);

            $table->integer('created_by')->unsigned()->default(0);
            $table->timestamps();

            $table->unique(['help_1_id', 'help_2_id'], self::table . '_unique');
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
