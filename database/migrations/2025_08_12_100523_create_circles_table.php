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
        Schema::create('circles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
    $table->foreignId('institute_id')->constrained()->cascadeOnDelete();
    $table->enum('type',['hifz','tajweed','arabic'])->index();
    $table->dateTime('start_time')->nullable();
    $table->dateTime('end_time')->nullable();
    $table->json('schedule')->nullable(); // لو بدك
    $table->string('level')->nullable();
    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
    $table->tinyInteger('status')->default(1)->index();
    $table->timestamps();
    $table->softDeletes();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circles');
    }
};
