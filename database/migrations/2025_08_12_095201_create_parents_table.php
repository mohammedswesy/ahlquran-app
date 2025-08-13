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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // حساب ولي الأمر نفسه
    $table->string('relation_type',50)->index(); // أب، أم، جد، ...
    $table->string('job_title')->nullable();
    $table->string('education_level')->nullable();
    $table->string('cv_file')->nullable();
    $table->string('marital_status',30)->nullable();
    $table->timestamps();
    $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
