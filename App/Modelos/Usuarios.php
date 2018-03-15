<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Usuarios extends Modelo
{
    public $timestamps = true;
    protected $table = 'usuarios';
    protected $fillable = array(
        'id',
        'nombre',
        'email',
        'password',
        'descripcion',
    );
    

}
