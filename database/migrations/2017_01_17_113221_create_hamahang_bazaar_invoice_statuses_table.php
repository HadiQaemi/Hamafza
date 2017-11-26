<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangBazaarInvoiceStatusesTable extends Migration
{

    const table = 'hamahang_bazaar_invoice_statuses';

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

            $table->integer('invoice_id')->default(0);
            $table->integer('status_id')->default(0);
            $table->integer('user_id')->unsigned()->default(0);

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
