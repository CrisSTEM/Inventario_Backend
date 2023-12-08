<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = ['codigo', 'nombre', 'existencia', 'precio'];

    public function ventas() {
        return $this->belongsToMany(Venta::class, 'producto_ventas', 'id_producto', 'id_venta')
                    ->withPivot('cantidad');
    }
}
