<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total', 'status', 'payment_method', 'payment_id'
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'order_product')
            ->withPivot('cantidad', 'precio');
    }
}