<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangBazaarGetPayIDsResultsTable extends Migration
{

    const table = 'hamahang_bazaar_getpayids_results';

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
            $table->text('errors')->nullable();
            $table->string('invoice_serial', '255')->nullable();
            $table->string('pay_due_ids_tax_fine', '255')->nullable();
            $table->timestamp('pay_request_date');
            $table->string('pay_request_trace_no', '255')->nullable();
            $table->string('status', '255')->nullable();
            $table->integer('succeed')->default(0);
            $table->text('full_data')->nullable();

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
