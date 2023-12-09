<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Producto;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = ['fecha', 'total', 'id_usuario', 'id_cliente'];

    // Relación existente con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Relación existente con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Definir la relación con Productos
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_venta', 'id_venta', 'id_producto');
    }
}
