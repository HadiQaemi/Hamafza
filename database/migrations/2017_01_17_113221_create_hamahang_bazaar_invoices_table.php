<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangBazaarInvoicesTable extends Migration
{

    const table = 'hamahang_bazaar_invoices';

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
            $table->integer('receiver_id')->default(0);
            $table->integer('postmethod_id')->default(0);
            $table->string('tracking_code','255')->nullable();
            $table->integer('payable_amount')->default(0);
            $table->integer('invoice_year')->default(0);
            $table->integer('invoice_serial')->default(0);
            $table->integer('has_coupon')->default(0);
            $table->string('pay_request_trace_no','255')->nullable();
            $table->string('pay_due_pay_id','255')->nullable();
            $table->integer('paid')->default(0);
            $table->string('paid_order_id','255')->nullable();
            $table->string('paid_refrence_no','255')->nullable();

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
