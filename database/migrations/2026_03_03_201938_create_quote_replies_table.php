<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')
                  ->constrained('quotes')
                  ->cascadeOnDelete();
            $table->text('message')->nullable();       // ← columna que faltaba
            $table->timestamp('sent_at');
            $table->string('meet_link')->nullable();
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')               // ← FK que faltaba
                  ->nullOnDelete();
            $table->timestamps();

            $table->index('quote_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_replies');
    }
};