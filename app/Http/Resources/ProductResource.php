<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'nome'          => $this->nome,
            'descricao'     => $this->descricao,
            'preco'         => number_format($this->preco, 2, '.', ''),
            'estoque'       => $this->estoque,
            'categoria'     => new CategoryResource($this->whenLoaded('categoria')),
            'criado_em'     => $this->created_at?->format('Y-m-d\TH:i:s\Z'),
            'atualizado_em' => $this->updated_at?->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
