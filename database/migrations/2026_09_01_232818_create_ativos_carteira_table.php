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
        Schema::create('ativos_carteira', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carteira_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('criptomoeda_id')->index()->constrained()->cascadeOnDelete();
            $table->decimal('quantidade', 20, 8);
            $table->decimal('preco_medio', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ativos_carteira');
    }
};
