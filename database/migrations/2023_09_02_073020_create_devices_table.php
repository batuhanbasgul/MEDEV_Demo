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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_id');
            $table->integer('company_id');
            $table->integer('corporation_id');
            $table->integer('department_id');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_no');
            $table->string('qr_code');
            $table->string('qr_code_path');
            $table->integer('spendable_count')->default(0);
            $table->longText('spendable_description')->nullable();
            $table->longText('note')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('ern_code')->nullable();
            $table->string('accessory')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
};
