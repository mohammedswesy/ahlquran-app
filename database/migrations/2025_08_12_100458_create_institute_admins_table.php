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
      Schema::create('institute_admins', function (Blueprint $table) {
    $table->id();

    $table->foreignId('institute_id')
          ->constrained()
          ->cascadeOnUpdate()
          ->cascadeOnDelete();

    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnUpdate()
          ->cascadeOnDelete();

    $table->enum('admin_type', ['default_admin','sub_admin'])->index();

    $table->unique(['institute_id','user_id']);
    $table->timestamps(); // مرة واحدة فقط
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institute_admins');
    }
};
