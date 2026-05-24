<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /**
     * Produto do catálogo.
     */
    protected $table = 'products';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'estoque',
        'categoria_id',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'estoque' => 'integer',
    ];

    /**
     * Constantes para serialização com nomes em português.
     */
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Categoria do produto.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }
}
