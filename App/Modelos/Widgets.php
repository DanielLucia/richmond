<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Widgets extends Modelo
{
    public $timestamps = true;
    protected $table = 'widgets';
    protected $fillable = array(
        'slug',
        'titulo',
        'descripcion',
        'class',
        'method',
    );


}
