<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';
    protected $fillable = ['nombre', 'password'];

    public function ventas() {
        return $this->hasMany(Venta::class, 'id_usuario');
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
    public function clientes() {
        return $this->hasMany(Cliente::class, 'usuario_id');
    }
    
}
