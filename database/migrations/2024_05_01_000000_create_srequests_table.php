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
        Schema::create('srequests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('latest_request_status',255)->nullable();
            $table->longText('description')->nullable();
            $table->text('title')->nullable();
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('srequests');
    }
};
