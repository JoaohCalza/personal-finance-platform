<?php

namespace App\Models;

use Database\Factories\CategoriaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nome', 'tipo'])]
class Categoria extends Model
{
    /** @use HasFactory<CategoriaFactory> */
    use HasFactory;

    public $timestamps = false;
}
