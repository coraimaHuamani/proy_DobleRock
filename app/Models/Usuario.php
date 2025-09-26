<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'telefono',
        'direccion',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'estado' => 'boolean',
        'rol' => 'integer',
    ];

    // Constantes para los roles
    const ROL_ADMIN = 1;
    const ROL_CLIENTE = 2;

    // Mutador para hashear la contraseña automáticamente
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Accessor para obtener el rol como string
    public function getRolNombreAttribute()
    {
        return $this->rol === self::ROL_ADMIN ? 'admin' : 'cliente';
    }

    // Scopes para filtrar por rol
    public function scopeAdmins($query)
    {
        return $query->where('rol', self::ROL_ADMIN);
    }

    public function scopeClientes($query)
    {
        return $query->where('rol', self::ROL_CLIENTE);
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    // Métodos de verificación de rol
    public function isAdmin()
    {
        return $this->rol === self::ROL_ADMIN;
    }

    public function isCliente()
    {
        return $this->rol === self::ROL_CLIENTE;
    }

    public function isActivo()
    {
        return $this->estado === true;
    }
}
