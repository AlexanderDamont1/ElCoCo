<?php
// database/migrations/xxxx_xx_xx_create_quotes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_company')->nullable();
            $table->string('client_phone')->nullable();
            $table->text('project_description')->nullable();
            $table->text('additional_requirements')->nullable();
            $table->json('data'); // Datos completos de la cotización
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('total', 12, 2);
            $table->integer('total_hours');
            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected', 'expired'])->default('draft');
            $table->timestamp('sent_at')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
            
            $table->index('reference');
            $table->index('client_email');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};