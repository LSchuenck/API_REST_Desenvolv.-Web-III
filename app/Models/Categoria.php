<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'idcategoria';

    protected $fillable = ['nome', 'descricao'];

    // Uma categoria tem vários livros
    public function livros()
    {
        return $this->hasMany(Livro::class, 'idcategoria');
    }
}
