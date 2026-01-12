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
        Schema::create('quote_replies', function (Blueprint $table) {
    $table->id();
    $table->foreignId('quote_id')->constrained()->cascadeOnDelete();
    $table->text('message');
    $table->string('sent_to_email');
    $table->timestamp('sent_at');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_replies');
    }
};
