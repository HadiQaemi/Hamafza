<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHamahangLogRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hamahang_log_requests', function (Blueprint $table) {
            $table->string('ip', 50)->nullable();
            $table->string('iso_code', 10)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('state_name', 255)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->double('lat', 7, 4)->nullable();
            $table->double('lon', 7, 4)->nullable();
			$table->string('timezone', 255)->nullable();
			$table->string('continent', 100)->nullable();
			$table->string('currency', 50)->nullable();
			$table->enum('default', array('1','0'))->nullable()->default('0');
			$table->enum('cached', array('1','0'))->nullable()->default('0');
			$table->string('url', 1000)->nullable();
			$table->string('uri', 1000)->nullable();
			$table->string('path', 1000)->nullable();
			$table->string('request_uri', 1000)->nullable();
			$table->text('query_string')->nullable();
			$table->integer('port')->nullable();
			$table->enum('ajax', array('1','0'))->nullable()->default('0');
			$table->string('method', 4)->nullable();
			$table->enum('is_secure', array('1','0'))->nullable()->default('0');
			$table->string('post_data', 255)->nullable();
			$table->string('response_format', 255)->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }	

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hamahang_log_requests');
    }
}
