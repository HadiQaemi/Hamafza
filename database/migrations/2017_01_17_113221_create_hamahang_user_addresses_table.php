<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangUserAddressesTable extends Migration
{

    const table = 'hamahang_user_addresses';

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

            $table->integer('user_id')->unsigned()->default(0);
            $table->string('receiver_name', 255)->nullable();
            $table->string('receiver_family', 255)->nullable();
            $table->integer('province_id')->default(0);
            $table->integer('city_id')->default(0);
            $table->string('address', 255)->nullable();
            $table->string('postal_code', 255)->nullable();
            $table->string('emergency_phone', 255)->nullable();
            $table->string('land_phone_precode', 255)->nullable();
            $table->string('land_phone_number', 255)->nullable();

            $table->integer('created_by')->unsigned()->default(0);
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
        Schema::dropIfExists(self::table);
    }

}
