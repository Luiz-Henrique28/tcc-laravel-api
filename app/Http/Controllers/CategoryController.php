<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Listar todas as categorias.
     */
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    /**
     * Criar nova categoria.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'data' => new CategoryResource($category),
        ], 201);
    }

    /**
     * Exibir uma categoria.
     */
    public function show(Category $category)
    {
        return response()->json([
            'data' => new CategoryResource($category),
        ]);
    }

    /**
     * Atualizar uma categoria.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $category->update($validated);

        return response()->json([
            'data' => new CategoryResource($category),
        ]);
    }

    /**
     * Remover uma categoria.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Categoria removida com sucesso.',
        ]);
    }
}
