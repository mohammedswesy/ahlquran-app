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
      Schema::create('employees', function (Blueprint $table) {
    $table->engine = 'InnoDB';

    $table->id();

    // FK -> users.id
    $table->foreignId('user_id')
          ->constrained('users', 'id')
          ->cascadeOnUpdate()
          ->cascadeOnDelete();

    // FK -> institutes.id (بدون NULL وبـ CASCADE)
    $table->foreignId('institute_id')
          ->constrained('institutes', 'id')
          ->cascadeOnUpdate()
          ->cascadeOnDelete();

    $table->string('job_title')->index();
    $table->string('cv_file')->nullable();
    $table->string('marital_status', 30)->nullable();
    $table->string('qualifications', 255)->nullable();
    $table->string('nationality', 100)->nullable();
    $table->string('address', 255)->nullable();
    $table->string('id_document')->nullable();

    $table->timestamps();
    $table->softDeletes();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
