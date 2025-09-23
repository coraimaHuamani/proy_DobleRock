<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galeria extends Model
{
    use HasFactory;

    protected $table = 'galerias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'archivo',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];
}
