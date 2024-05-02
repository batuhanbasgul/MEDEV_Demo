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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('job_title');
            $table->text('job_context');
            $table->integer('assigned_from');
            $table->integer('assigned_to');
            $table->integer('company_id');
            $table->unsignedBigInteger('serial_number');
            $table->boolean('is_multiple_user')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('is_success')->default(0);
            $table->text('unsuccess_reason')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
