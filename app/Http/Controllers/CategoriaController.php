<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return Categoria::all();
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:45',
            'descricao' => 'nullable|string|max:255',
        ]);

        return Categoria::create($dados);
    }

    public function show(Categoria $categoria)
    {
        return $categoria;
    }

    public function update(Request $request, Categoria $categoria)
    {
        $dados = $request->validate([
            'nome' => 'sometimes|required|string|max:45',
            'descricao' => 'nullable|string|max:255',
        ]);

        $categoria->update($dados);
        return $categoria;
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return response()->noContent();
    }
}
