<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmartdetectTable extends Migration
{

    const table = 'smartdetect';

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

            $table->string('content', 255)->nullable();
            $table->enum('content_type', ['variant', 'ip', 'domain', 'user_id', 'user_email', 'request_any', 'request_get', 'request_post'])->default('variant');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['content', 'content_type', ], self::table . '_unique');
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
