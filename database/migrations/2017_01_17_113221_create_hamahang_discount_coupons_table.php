<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangDiscountCouponsTable extends Migration
{

    const table = 'hamahang_discount_coupons';

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

            $table->string('coupon', 255)->nullable();
            $table->integer('type')->default(0);
            $table->integer('value')->default(0);
            $table->date('start_date');
            $table->date('expire_date');
            $table->integer('disposable')->default(0);
            $table->integer('usage_quota')->default(0);
            $table->integer('used_count')->default(0);
            $table->integer('subject_id')->default(0);
            $table->integer('subject_usage_quota')->default(0);
            $table->integer('coupon_request_id')->default(0);
            $table->integer('subject_used_count')->default(0);
            $table->integer('inactive')->default(0);

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
