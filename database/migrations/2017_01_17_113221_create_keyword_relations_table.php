<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKeywordRelationsTable extends Migration
{

    const table = 'keyword_relations';

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

            $table->integer('keyword_1_id')->unsigned()->default(0);
            $table->integer('keyword_2_id')->unsigned()->default(0);
            $table->enum('relation_type', ['1', '110', '3', '310', '5', '510', '7', '8', '12', '13', '21', '20', '9', '10'])->default('1');
            $table->integer('created_by')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['keyword_1_id', 'keyword_2_id', 'relation_type', 'deleted_at'], self::table . '_unique');
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
