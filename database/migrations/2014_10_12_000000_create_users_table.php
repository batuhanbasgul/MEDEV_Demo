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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('company_id')->default(0);
            $table->string('department')->nullable();
            $table->string('authority')->default('temporary'); //admin,client,subclient,temporary
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('p_image')->nullable();
            $table->string('start_date')->nullable();
            $table->integer('work_count')->default(0);
            $table->string('lang')->default('tr');
            $table->boolean('theme')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
