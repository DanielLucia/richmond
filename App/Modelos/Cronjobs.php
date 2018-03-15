<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Cronjobs extends Modelo
{
    public $timestamps = true;
    protected $table = 'cronjobs';
    protected $fillable = array(
        'slug',
        'programacion',
        'tarea',
    );


}
