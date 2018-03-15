<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class logHistory extends Modelo
{
    public $timestamps = true;
    protected $table = 'log_history';
    protected $fillable = array(
        'id',
        'user_id',
        'modelo',
        'accion',
        'data',
    );

}
