<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Connections extends Modelo
{
    public $timestamps = true;
    protected $table = 'connections';
    protected $fillable = array(
        'user_id',
        'ip',
        'agent',
        'banned',
        'logged',
        'location',
        'hostname',
        'org',
    );

}
