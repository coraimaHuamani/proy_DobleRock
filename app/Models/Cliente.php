<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        'direccion',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    /**
     * Relación con carritos
     * Un cliente puede tener muchos carritos (aunque normalmente uno activo)
     */
    public function carritos()
    {
        return $this->hasMany(Carrito::class);
    }

    /**
     * Relación con pedidos
     * Un cliente puede tener muchos pedidos
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
