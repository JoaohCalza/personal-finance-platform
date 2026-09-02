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
        Schema::create('operacoes_cripto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carteira_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('criptomoeda_id')->index()->constrained()->cascadeOnDelete();
            $table->string('tipo');
            $table->decimal('quantidade', 20, 8);
            $table->decimal('preco_unitario', 15, 2);
            $table->decimal('taxas', 15, 2)->nullable();
            $table->date('data_operacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operacoes_cripto');
    }
};
