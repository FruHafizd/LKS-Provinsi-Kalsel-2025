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
        Schema::create('installment_apply_socities', function (Blueprint $table) {
            $table->id();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('available_month_id')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('society_id');
            $table->unsignedBigInteger('installment_id')->nullable();
            $table->foreign('society_id')->references('id')->on('societies')->onDelete('cascade');
            $table->foreign('installment_id')->references('id')->on('installments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_apply_socities');
    }
};
