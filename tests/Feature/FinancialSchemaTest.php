<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FinancialSchemaTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_financial_tables_contain_the_columns_from_the_data_model(): void
    {
        $expectedColumns = [
            'users' => ['telegram_chat_id', 'telegram_usuario'],
            'categorias' => ['user_id', 'nome', 'tipo'],
            'carteiras' => ['user_id', 'nome', 'created_at', 'updated_at'],
            'criptomoedas' => ['nome', 'simbolo', 'api_id'],
            'alertas' => ['user_id', 'criptomoeda_id', 'tipo', 'valor_alvo', 'ativo'],
            'movimentacoes' => ['user_id', 'categoria_id', 'tipo', 'valor', 'descricao', 'data_movimentacao'],
            'ativos_carteira' => ['carteira_id', 'criptomoeda_id', 'quantidade', 'preco_medio'],
            'operacoes_cripto' => ['carteira_id', 'criptomoeda_id', 'tipo', 'quantidade', 'preco_unitario', 'taxas', 'data_operacao'],
            'investimentos_renda_fixa' => ['user_id', 'tipo', 'valor_aplicado', 'taxa', 'data_aplicacao', 'data_vencimento'],
        ];

        foreach ($expectedColumns as $table => $columns) {
            $this->assertTrue(Schema::hasColumns($table, $columns), "The [$table] table does not match the financial data model.");
        }
    }

    public function test_optional_financial_columns_are_nullable(): void
    {
        $nullableColumns = [
            'users' => ['telegram_usuario'],
            'movimentacoes' => ['descricao'],
            'operacoes_cripto' => ['taxas'],
            'investimentos_renda_fixa' => ['taxa', 'data_vencimento'],
        ];

        foreach ($nullableColumns as $table => $columns) {
            $tableColumns = collect(Schema::getColumns($table))->keyBy('name');

            foreach ($columns as $column) {
                $this->assertTrue($tableColumns[$column]['nullable'], "The [$table.$column] column must be nullable.");
            }
        }
    }

    public function test_financial_tables_reference_the_expected_parent_tables(): void
    {
        $expectedForeignKeys = [
            'categorias' => ['user_id' => 'users'],
            'carteiras' => ['user_id' => 'users'],
            'alertas' => ['user_id' => 'users', 'criptomoeda_id' => 'criptomoedas'],
            'movimentacoes' => ['user_id' => 'users', 'categoria_id' => 'categorias'],
            'ativos_carteira' => ['carteira_id' => 'carteiras', 'criptomoeda_id' => 'criptomoedas'],
            'operacoes_cripto' => ['carteira_id' => 'carteiras', 'criptomoeda_id' => 'criptomoedas'],
            'investimentos_renda_fixa' => ['user_id' => 'users'],
        ];

        foreach ($expectedForeignKeys as $table => $foreignKeys) {
            $tableForeignKeys = collect(Schema::getForeignKeys($table))
                ->mapWithKeys(fn (array $foreignKey): array => [$foreignKey['columns'][0] => $foreignKey['foreign_table']]);

            foreach ($foreignKeys as $column => $foreignTable) {
                $this->assertSame($foreignTable, $tableForeignKeys[$column], "The [$table.$column] foreign key points to the wrong table.");
            }
        }
    }
}
