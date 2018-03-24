<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Contacts extends Modelo
{
    public $timestamps = true;
    protected $table = 'contacts';
    protected $fillable = array(
        'nombre',
        'telefono',
        'user_id',
    );

}
