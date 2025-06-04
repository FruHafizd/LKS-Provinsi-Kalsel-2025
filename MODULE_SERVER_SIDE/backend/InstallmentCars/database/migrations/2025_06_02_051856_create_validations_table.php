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
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('society_id');
            $table->unsignedBigInteger('validator_id')->nullable();
            $table->enum('status',['accepted','declined','pending'])->default('pending');
            $table->string('job')->nullable();
            $table->text('job_description')->nullable();
            $table->integer('income')->nullable();
            $table->text('reason_accepted')->nullable();
            $table->text('validator_notes')->nullable();
            $table->foreign('society_id')->references('id')->on('societies')->onDelete('cascade');
            $table->foreign('validator_id')->references('id')->on('validators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validations');
    }
};
