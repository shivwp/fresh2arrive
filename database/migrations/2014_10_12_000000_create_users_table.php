<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_driver')->default(0);
            $table->boolean('is_vendor')->default(0);
            $table->float('wallet_balance',10,2);
            $table->string('name',255);
            $table->string('phone',255)->unique();
            $table->string('email')->unique();
            $table->integer('otp');
            $table->string('profile_image',255);
            $table->string('latitude',255);
            $table->string('longitude',255);
            $table->string('location',255);
            $table->bigInteger('default_address');
            $table->string('referal_code',255)->unique();
            $table->text('device_token');
            $table->string('device_id',255)->unique();
            $table->boolean('is_driver_online')->default(0);
            $table->tinyInteger('delivery_range')->default(0);
            $table->boolean('self_delivery')->default(0);
            $table->float('admin_commission',6,2)->default(10);
            $table->boolean('as_driver_verified')->default(0);
            $table->boolean('as_vendor_verified')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('status')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
