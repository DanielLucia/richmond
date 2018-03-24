<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class emailsAccount extends Modelo
{
    public $timestamps = true;
    protected $table = 'emails_accounts';
    protected $fillable = array(
        'user_id',
        'host',
        'account',
        'password',
        'port',
        'ssl',
    );

}
