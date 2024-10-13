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
        Schema::create('org_user_delegates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('org_user_id')->constrained('org_users');
            $table->foreignId('organization_id')->constrained('organizations');
            $table->string('address');
            $table->bigInteger('phone_number');
            $table->foreignId('account_status')->default(1)->constrained('account_status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_user_delegates');
    }
};
