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
                  ->constrained()
                  ->cascadeOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index('quote_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_replies');
    }
};