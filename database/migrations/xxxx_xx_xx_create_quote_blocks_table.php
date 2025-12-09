<?php
// database/migrations/xxxx_xx_xx_create_quote_blocks_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('quote_block_categories')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type'); // course, audit, maintenance, software_module, section
            $table->decimal('base_price', 10, 2)->default(0);
            $table->integer('default_hours')->default(0);
            $table->json('config')->nullable(); // Configuración específica del bloque
            $table->text('formula')->nullable(); // Fórmula de cálculo
            $table->json('validation_rules')->nullable(); // Reglas de validación
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_blocks');
    }
};