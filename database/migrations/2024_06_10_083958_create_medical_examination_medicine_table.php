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
        Schema::create('medical_examination_medicine', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_examination_id');
            $table->unsignedBigInteger('medicine_id');
            $table->timestamps();

            $table->foreign('medical_examination_id')->references('id')->on('medical_examinations')->onDelete('cascade');
            $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_examination_medicine');
    }
};
