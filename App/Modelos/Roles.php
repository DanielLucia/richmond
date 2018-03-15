<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Roles extends Modelo
{
    public $timestamps = true;
    protected $table = 'usuarios_roles';
    protected $fillable = array(
        'id',
        'nombre',
    );
    

}
