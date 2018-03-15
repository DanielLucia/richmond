<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Permission extends Modelo
{
    public $timestamps = true;
    protected $table = 'usuarios_roles_zonas';
    protected $fillable = array(
        'id',
        'zona',
        'rol',
    );
    

}
