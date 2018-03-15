<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Notificaciones extends Modelo
{
    public $timestamps = true;
    protected $table = 'notificaciones';
    protected $fillable = array(
        'id_user',
        'title',
        'text',
        'viewed',
    );


}
