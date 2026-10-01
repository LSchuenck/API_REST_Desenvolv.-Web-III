<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $table = 'livro';
    protected $primaryKey = 'idlivro';

    protected $fillable = ['titulo', 'isbn', 'anopublicacao', 'descricao', 'paginas', 'idautor', 'idcategoria'];

    // Um livro pertence a um autor
    public function autor()
    {
        return $this->belongsTo(Autor::class, 'idautor');
    }

    // Um livro pertence a uma categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idcategoria');
    }
}
