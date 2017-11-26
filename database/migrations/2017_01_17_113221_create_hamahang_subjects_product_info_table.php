<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangSubjectsProductInfoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects_product_info', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('subject_id')->unsigned()->default(0);
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('responsible_for_sales_id')->default(0);
            $table->integer('weight')->default(0);
            $table->string('size', 255)->nullable();
            $table->integer('shipping_cost')->default(0);
            $table->integer('maximum_delivery_time')->nullable();
            $table->integer('how_to_send')->default(0);
            $table->integer('count')->default(0);
            $table->string('payment_methods', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('ready_to_supply')->nullable()->default(0);

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
        Schema::dropIfExists('subjects_product_info');
    }

}
