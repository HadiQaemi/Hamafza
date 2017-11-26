<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKeywordsTable extends Migration
{

    const table = 'keywords';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::table, function(Blueprint $table)
        {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->increments('id')->unsigned();

            $table->string('title', 255);
            $table->string('short_code', 255)->nullable();
            $table->integer('img_file_id')->unsigned()->default(0);
            $table->text('description')->nullable();
            $table->tinyInteger('is_morajah')->default(0);
            $table->tinyInteger('is_approved')->default(0);

            $table->integer('created_by')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['title'], self::table . '_unique');
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
