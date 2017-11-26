<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('relations', function(Blueprint $table) {
            $table->increments('id')->unsigned();
			$table->integer('uid')->unsigned()->default(0);
            $table->string('name', 250);
            $table->smallInteger('variables');
            $table->smallInteger('concepts')->default(0);
            $table->smallInteger('pages')->default(0);
            $table->string('directname', 250);
            $table->string('Inversename', 250);
			$table->smallInteger('direction')->default(0);
            $table->string('dariche', 250);
            $table->longText('descr');
            $table->string('dariche_inver', 250);
            $table->integer('parent')->default(0);
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
        Schema::dropIfExists('relations');
    }

}
