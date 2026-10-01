<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autor';
    protected $primaryKey = 'idautor';

    protected $fillable = ['nome', 'nacionalidade', 'nascimento', 'biografia'];

    // Um autor tem vários livros
    public function livros()
    {
        return $this->hasMany(Livro::class, 'idautor');
    }
}
