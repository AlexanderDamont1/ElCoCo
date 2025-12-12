<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type');
            $table->foreignId('category_id')->constrained('quote_block_categories')->onDelete('cascade');
            $table->decimal('base_price', 10, 2)->default(0);
            $table->integer('default_hours')->default(0);
            $table->json('config')->nullable();
            $table->text('formula')->nullable();
            $table->json('validation_rules')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index('category_id');
            $table->index('is_active');
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_blocks');
    }
};