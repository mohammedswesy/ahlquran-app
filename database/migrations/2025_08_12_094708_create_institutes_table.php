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
        Schema::create('institutes', function (Blueprint $table) {
    $table->engine = 'InnoDB';

    $table->id(); // <- مهم جداً: PK unsigned bigInt

    $table->string('name')->index();
    $table->foreignId('country_id')
          ->constrained()
          ->cascadeOnUpdate()
          ->restrictOnDelete();

    $table->foreignId('city_id')
          ->constrained()
          ->cascadeOnUpdate()
          ->restrictOnDelete();

    $table->foreignId('organization_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete(); // معهد ممكن بلا منظمة

    $table->decimal('latitude', 10, 7)->nullable();
    $table->decimal('longitude', 10, 7)->nullable();

    $table->foreignId('created_by')
          ->nullable()
          ->constrained('users')
          ->nullOnDelete();

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
        Schema::dropIfExists('institutes');
    }
};
