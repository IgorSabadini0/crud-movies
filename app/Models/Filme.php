<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    protected $fillable = ['titulo', 'descricao', 'imagem']; // protected pode ser usado apenas dentro do namespace que foi definido, ou seja, dentro do app/Models
}
