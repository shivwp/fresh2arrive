<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->date('dob');
            $table->string('aadhar_no',255)->unique();
            $table->string('pan_no',255)->unique();
            $table->string('vehicle_no',255)->unique();
            $table->string('license_no',255)->unique();
            $table->string('bank_statement',255);
            $table->string('pan_card_image',255);
            $table->string('license_front_image',255);
            $table->string('license_back_image',255);
            $table->string('aadhar_front_image',255);
            $table->string('aadhar_back_image',255);
            $table->text('remark');
            $table->boolean('status')->default(0)->comment('0 = Pending, 1 = Approved by Admin');
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
        Schema::dropIfExists('driver_profiles');
    }
}
