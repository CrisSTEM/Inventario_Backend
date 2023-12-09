<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['nombre', 'rif', 'direccion', 'telefono', 'vendedor','usuario_id'];

    public function ventas() {
        return $this->hasMany(Venta::class, 'id_cliente');
    }
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
    
}