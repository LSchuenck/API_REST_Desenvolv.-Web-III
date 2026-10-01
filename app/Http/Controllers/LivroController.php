<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    // with() traz junto os dados do autor e da categoria de cada livro
    public function index()
    {
        return Livro::with(['autor', 'categoria'])->get();
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:45',
            'anopublicacao' => 'nullable|integer',
            'descricao' => 'nullable|string|max:255',
            'paginas' => 'nullable|integer',
            'idautor' => 'required|exists:autor,idautor',
            'idcategoria' => 'required|exists:categoria,idcategoria',
        ]);

        return Livro::create($dados);
    }

    public function show(Livro $livro)
    {
        return $livro->load(['autor', 'categoria']);
    }

    public function update(Request $request, Livro $livro)
    {
        $dados = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'isbn' => 'nullable|string|max:45',
            'anopublicacao' => 'nullable|integer',
            'descricao' => 'nullable|string|max:255',
            'paginas' => 'nullable|integer',
            'idautor' => 'sometimes|required|exists:autor,idautor',
            'idcategoria' => 'sometimes|required|exists:categoria,idcategoria',
        ]);

        $livro->update($dados);
        return $livro;
    }

    public function destroy(Livro $livro)
    {
        $livro->delete();
        return response()->noContent();
    }
}
