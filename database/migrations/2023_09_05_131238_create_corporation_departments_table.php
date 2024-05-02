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
        Schema::create('corporation_departments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('corporation_id');
            $table->integer('company_id');
            $table->string('name');
            $table->string('person');
            $table->string('contact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corporation_departments');
    }
};
