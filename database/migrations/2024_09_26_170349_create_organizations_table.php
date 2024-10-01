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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('post_office_address');
            $table->string('image')->nullable();
            $table->foreignId('category')->constrained('organization_categories');
            $table->string('email');
            $table->foreignId('activated_by')->constrained('users');
            $table->enum('account_status', [0, 1])->default(1);
            $table->string('sms_api_key')->nullable();
            $table->string('sms_api_secret_key')->nullable();
            $table->string('sms_provider')->nullable();
            $table->boolean('manage_clock_in')->default(false);
            $table->boolean('signature_clock_in')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
