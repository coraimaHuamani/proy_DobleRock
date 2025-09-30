<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Galeria extends Model
{
    use HasFactory;

    protected $table = 'galerias';

    protected $appends = ['archivo_url'];

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

    public function getArchivoUrlAttribute()
    {
        return $this->archivo
            ? Storage::disk('public')->url($this->archivo)
            : null;
    }
}
