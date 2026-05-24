<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Listar todos os produtos (com categoria via eager loading / JOIN).
     * Suporta filtro por categoria: ?category=<id>
     * Paginação: 20 itens por página.
     */
    public function index(Request $request)
    {
        $query = Product::with('categoria');

        // Filtro por categoria
        if ($request->has('category')) {
            $query->where('categoria_id', $request->input('category'));
        }

        $products = $query->paginate(20);

        return ProductResource::collection($products);
    }

    /**
     * Criar novo produto.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'         => 'required|string|max:255',
            'descricao'    => 'nullable|string',
            'preco'        => 'required|numeric|min:0',
            'estoque'      => 'required|integer|min:0',
            'categoria_id' => 'required|integer|exists:categories,id',
        ]);

        $product = Product::create($validated);
        $product->load('categoria');

        return response()->json([
            'data' => new ProductResource($product),
        ], 201);
    }

    /**
     * Exibir um produto.
     */
    public function show(Product $product)
    {
        $product->load('categoria');

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Atualizar um produto.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nome'         => 'required|string|max:255',
            'descricao'    => 'nullable|string',
            'preco'        => 'required|numeric|min:0',
            'estoque'      => 'required|integer|min:0',
            'categoria_id' => 'required|integer|exists:categories,id',
        ]);

        $product->update($validated);
        $product->load('categoria');

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Remover um produto.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Produto removido com sucesso.',
        ]);
    }
}
