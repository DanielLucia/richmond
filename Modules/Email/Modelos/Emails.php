<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class Emails extends Modelo
{
    public $timestamps = true;
    protected $table = 'emails';
    protected $fillable = array(
        'id',
        'uid',
        'leido',
        'id_email',
        'mailbox',
        'user_id',
        'title',
        'email_from',
        'email_to',
        'body',
        'date',
    );

}
