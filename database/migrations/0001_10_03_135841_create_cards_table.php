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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_number');
            $table->unsignedBigInteger('org_user_id');
            // $table->unsignedBigInteger('card_type_id');
            // $table->unsignedBigInteger('payment_method_id');
            $table->string('card_status')->default('active');
            $table->foreign('org_user_id')->references('id')->on('org_users');
            // $table->foreign('card_type_id')->references('id')->on('card_types');
            // $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
