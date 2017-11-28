<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangHelpRelationsTable extends Migration
{

    const table = 'hamahang_help_relations';

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
            $table->string('target_type', 255)->nullable();
            $table->integer('target_id')->default(0);
            $table->integer('help_id')->default(0);
            $table->integer('created_by')->unsigned()->default(0);
            $table->timestamps();

            $table->unique(['target_type', 'target_id', ], self::table . '_unique');
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
