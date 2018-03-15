<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Configuracion extends Modelo
{
    public $timestamps = true;
    protected $table = 'configuracion';
    protected $fillable = array(
        'id',
        'config',
        'value',
    );
    

}
