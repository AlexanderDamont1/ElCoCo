<?php
// database/migrations/xxxx_create_quote_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->onDelete('cascade');
            $table->foreignId('quote_block_id')->constrained('quote_blocks')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type');
            $table->integer('quantity')->default(1);
            $table->integer('hours')->default(0);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->json('data')->nullable();
            $table->timestamps();
            
            $table->index('quote_id');
            $table->index('quote_block_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};