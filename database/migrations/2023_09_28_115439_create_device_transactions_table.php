<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('company_id');
            $table->integer('corporation_id');
            $table->string('corporation_name');
            $table->integer('department_id');
            $table->string('department_name');
            $table->integer('product_id');
            $table->string('product_name');
            $table->integer('device_id');
            $table->string('device_name');
            $table->string('device_brand');
            $table->string('device_model');
            $table->string('device_serial_no');
            $table->integer('personel_id');
            $table->string('personel_name');
            $table->longText('description')->nullable();
            $table->string('verifier_name');
            $table->string('verifier_tel');
            $table->boolean('is_verified')->default(0);
            $table->string('record_no_to')->nullable();
            $table->string('record_no_from')->nullable();
            $table->string('transactions');
            $table->integer('controller_id')->nullable();
            $table->string('controller_name')->nullable();
            $table->string('control_date')->nullable();
            $table->string('service_in_date')->nullable();
            $table->string('service_out_date')->nullable();
            $table->string('calibration_tag_date')->nullable();
            $table->string('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_transactions');
    }
};
