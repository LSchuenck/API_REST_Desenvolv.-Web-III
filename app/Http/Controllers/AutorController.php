<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        return Autor::all();
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:45',
            'nacionalidade' => 'nullable|string|max:45',
            'nascimento' => 'nullable|date',
            'biografia' => 'nullable|string',
        ]);

        return Autor::create($dados);
    }

    public function show(Autor $autor)
    {
        return $autor;
    }

    public function update(Request $request, Autor $autor)
    {
        $dados = $request->validate([
            'nome' => 'sometimes|required|string|max:45',
            'nacionalidade' => 'nullable|string|max:45',
            'nascimento' => 'nullable|date',
            'biografia' => 'nullable|string',
        ]);

        $autor->update($dados);
        return $autor;
    }

    public function destroy(Autor $autor)
    {
        $autor->delete();
        return response()->noContent();
    }
}
