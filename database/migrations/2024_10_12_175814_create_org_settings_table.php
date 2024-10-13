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
        Schema::create('org_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('clock_in_type')->default('signature')->comment('can be signature or card');
            $table->string('clock_out_type')->nullable()->comment('can be signature or card');
            $table->boolean('card_enabled')->default(false);
            $table->boolean('initiate_clock_in')->default(false);
            $table->boolean('initiate_clock_out')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_settings');
    }
};
