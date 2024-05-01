<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('middle_name',255)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('employee_no',255)->nullable();
            $table->string('gender',50)->nullable();
            $table->longText('imagefile')->nullable();
            $table->string('email')->unique();
            $table->longText('address1')->nullable();
            $table->longText('address2')->nullable();
            $table->string('phone_number',100)->nullable();
            $table->string('mobile_number',100)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('employees');
    }
};
