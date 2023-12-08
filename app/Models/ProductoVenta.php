<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoVenta extends Model
{
    protected $table = 'producto_venta';
    protected $fillable = ['id_producto', 'id_venta', 'cantidad'];

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
    
    public function cliente() {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
    
    public function productos() {
        return $this->belongsToMany(Producto::class, 'producto_ventas', 'id_venta', 'id_producto')
                    ->withPivot('cantidad');
    }
    
}