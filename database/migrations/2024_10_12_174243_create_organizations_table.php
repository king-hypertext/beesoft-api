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
            $table->string('name')->unique('organization');
            $table->string('post_office_address')->unique('address');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('activated_by')->constrained('users');
            $table->foreignId('category_id')->constrained('org_categories');
            $table->string('image')->nullable();
            $table->string('email')->unique('email');
            $table->string('sms_api_key')->nullable();
            $table->string('sms_api_secret_key')->nullable();
            $table->string('sms_provider')->nullable();
            $table->boolean('manage_clock_in')->default(false);
            $table->boolean('signature_clock_in')->default(false);
            $table->foreignId('account_status_id')->constrained('account_status');
            $table->softDeletes();
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
