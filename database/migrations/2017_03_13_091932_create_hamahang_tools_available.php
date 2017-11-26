<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateHamahangToolsAvailable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_tools_available',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('uid')->default(0)->unsigned();
            $table->string('title')->default(null);
            $table->string('url')->default(null);
            $table->longText('description')->default(null)->nullable();
            $table->integer('modal')->default(0);
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
        Schema::dropIfExists('hamahang_tools_available');
    }
}
