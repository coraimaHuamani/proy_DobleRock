<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'fecha_creacion',
        'rol',
        'email',
        'password',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'fecha_creacion' => 'date',
        'estado' => 'boolean',
    ];

    // 🚀 Constantes de roles
    public const ROLES = [
        1 => 'Admin',
        2 => 'Editor',
        3 => 'Usuario',
    ];

    // 🚀 Accesor para mostrar el nombre del rol
    public function getRolNombreAttribute()
    {
        return self::ROLES[$this->rol] ?? 'Sin rol';
    }
}
