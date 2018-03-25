<?php
namespace Escuchable\Modelos;

use Escuchable\App\Modelo as Modelo;

class emailsMailboxes extends Modelo
{
    public $timestamps = true;
    protected $table = 'emails_mailboxes';
    protected $fillable = array(
        'user_id',
        'email_account',
        'title',
    );

}
