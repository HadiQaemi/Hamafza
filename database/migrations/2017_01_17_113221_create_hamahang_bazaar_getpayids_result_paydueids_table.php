<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHamahangBazaarGetPayIDsResultPayDueIDsTable extends Migration
{

    const table = 'hamahang_bazaar_getpayids_result_paydueids';

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

            $table->integer('getpayids_result_id')->default(0);
            $table->text('errors')->nullable();
            $table->string('_id', '255')->default(0);
            $table->timestamp('issue_date');
            $table->string('pay_due_serial', '255')->nullable();
            $table->string('status', '255')->nullable();
            $table->string('trace_no', '255')->nullable();

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
