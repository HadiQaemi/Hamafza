<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSitesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sites', function(Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->integer('uid')->unsigned()->default(0);
            $table->string('name', 500)->nullable();
            $table->string('url', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sites');
    }

}
