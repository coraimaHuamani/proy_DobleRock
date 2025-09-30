<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'image',
        'source_url',
    ];
    
    protected $appends = ['image_url'];


    // Constantes para categorías
    public const CATEGORIES = [
        'noticia' => 'Noticia',
        'evento' => 'Evento',
    ];

    // Accesor para mostrar el nombre de la categoría
    public function getCategoryNameAttribute()
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    // Scope para obtener solo noticias
    public function scopeNoticias($query)
    {
        return $query->where('category', 'noticia');
    }

    // Scope para obtener solo eventos
    public function scopeEventos($query)
    {
        return $query->where('category', 'evento');
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? Storage::disk('public')->url($this->image)
            : null;
    }
}
