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
        Schema::create('avaible_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('installment_id');
            $table->integer('month')->nullable();
            $table->text('description')->nullable();
            $table->integer('nominal')->nullable();
            $table->foreign('installment_id')->references('id')->on('installments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaible_months');
    }
};
