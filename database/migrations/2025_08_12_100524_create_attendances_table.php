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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained()->cascadeOnDelete();  // يعمل للطالب/المعلم/الموظف
    $table->foreignId('circle_id')->nullable()->constrained()->nullOnDelete(); // لو الحضور مرتبط بحلقة
    $table->dateTime('start_time')->index(); // من
    $table->dateTime('end_time')->nullable(); // إلى
    $table->enum('status',['present','absent','excused'])->default('present')->index();
    $table->text('excuse')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
