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
        Schema::create('org_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->string('mum_phone')->nullable();
            $table->string('dad_phone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('department_id')->constrained('org_departments');
            $table->string('gender');
            $table->string('parental_action');
            $table->string('voice')->nullable();
            $table->foreignId('card_id')->nullable()->constrained('cards');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_users');
    }
};
