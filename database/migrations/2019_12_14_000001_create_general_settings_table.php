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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('clover_client_id');
            $table->string('clover_employee_id');
            $table->string('clover_merchant_id');
            $table->string('clover_tender_id');
            $table->string('clover_client_secret');
            $table->string('clover_bearer_token');
            $table->json('clover_bearer_token_object');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
