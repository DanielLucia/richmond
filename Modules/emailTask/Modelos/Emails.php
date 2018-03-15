<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Emails extends Modelo
{
    public $timestamps = true;
    protected $table = 'emails';
    protected $fillable = array(
        'id',
        'user_id',
        'title',
        'body',
    );

}
