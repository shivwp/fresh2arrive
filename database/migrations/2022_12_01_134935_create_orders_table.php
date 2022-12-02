<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('address_id')->constrained('user_addresses');
            $table->string('coupon_code',255);
            $table->float('item_total',7,2);
            $table->float('delivery_charges',7,2);
            $table->integer('tip_amount');
            $table->float('grand_total',7,2);
            $table->foreignId('driver_id')->constrained('users');
            $table->float('commission_driver',7,2);
            $table->float('commission_admin',7,2);
            $table->enum('status',['P','A','PR','R'])->comment('P = Pending, A = Approved, PR = Partial Reject, R = Reject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
