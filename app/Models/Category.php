<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * Categoria de produto.
     */
    public $timestamps = false;

    protected $table = 'categories';

    protected $fillable = ['nome', 'descricao'];

    /**
     * Produtos desta categoria.
     */
    public function produtos(): HasMany
    {
        return $this->hasMany(Product::class, 'categoria_id');
    }
}
