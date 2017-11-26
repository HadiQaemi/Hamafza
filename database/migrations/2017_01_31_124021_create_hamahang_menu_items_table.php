<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHamahangMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by')->unsigned()->default(0);
			$table->integer('menu_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned()->default('0');
            $table->enum('status', array('0','1'))->default('0');
            $table->enum('href_type', array('0','1'))->default('0');
            $table->integer('order')->unsigned()->default(0);
            $table->string('title', 255);
            $table->string('description', 1000)->default(null);
            $table->string('route_name',1000)->default(null);
            $table->string('href', 1000)->default(null);
            $table->string('variables', 1000)->default(null);
            $table->string('target', 10)->default('_self');
            $table->string('icon', 255)->nullable();
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
        Schema::dropIfExists('hamahang_menu_items');
    }
}
