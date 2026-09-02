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
        Schema::create('investimentos_renda_fixa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained()->cascadeOnDelete();
            $table->string('tipo');
            $table->decimal('valor_aplicado', 15, 2);
            $table->decimal('taxa', 10, 4)->nullable();
            $table->date('data_aplicacao');
            $table->date('data_vencimento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investimentos_renda_fixa');
    }
};
