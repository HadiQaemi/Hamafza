<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangBookmarksTable extends Migration
{

    const table = 'hamahang_bookmarks';

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

            $table->string('title', 255)->nullable();
            $table->string('target_table', 255)->nullable();
            $table->integer('target_id')->default(0);
            $table->integer('user_id')->default(0)->unsigned();
            $table->integer('created_by')->default(0)->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['target_table', 'target_id', 'user_id', 'deleted_at'], self::table . '_unique');
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
