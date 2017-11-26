<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangBazaarInvoiceItemsTable extends Migration
{

    const table = 'hamahang_bazaar_invoice_items';

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

            $table->integer('invoice_id')->unsigned()->default(0);
            $table->integer('subject_id')->default(0);
            $table->string('subject_title', 255)->nullable();
            $table->integer('subject_price')->default(0);
            $table->integer('subject_count')->default(0);
            $table->integer('total_price')->default(0);
            $table->integer('coupon_id')->default(0);
            $table->integer('final_price')->default(0);
            $table->integer('responsible_for_sales_id')->unsigned()->default(0);

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
