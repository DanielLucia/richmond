<?php

/*
Plugin Name: Email
Slug: email
Description: PermiteU leer emails dentro del sistema
Version: 0.0.1
Author: daniellucia.es
*/

use Escuchable\App\Modulo;
use Escuchable\App\Request;
use Escuchable\App\Menu;
use Escuchable\App\Utils;
use Escuchable\App\Session;
use Escuchable\App\Url;

use Escuchable\Modelos\Emails;
use Escuchable\Modelos\Cronjobs;
use Escuchable\Modelos\Widgets;
use Escuchable\Modelos\Configuracion;

use Illuminate\Database\Query\Expression as raw;
use Illuminate\Database\Capsule\Manager as DB;

class emailModule extends Modulo
{
    public static $db = [
        'table' => 'emails',
        'fields' => [
            ['id', 'INT'],
            ['uid', 'INT'],
            ['user_id', 'INT'],
            ['id_email', 'VARCHAR (100)'],
            ['title', 'VARCHAR (200)'],
            ['email_from', 'VARCHAR (100)'],
            ['email_to', 'VARCHAR (100)'],
            ['body', 'TEXT'],
            ['mailbox', 'VARCHAR (100)'],
            ['date', 'DATETIME'],
            ['created_at', 'DATETIME'],
            ['updated_at', 'DATETIME'],
        ],
        'primary' => 'id',
    ];

    public function __construct()
    {
        $this->route = __DIR__;
        $this->has_configuration = true;

        //Menu
        Menu::add(1, array('navbar'), 'Bandeja de entrada', 'inbox', 'envelope-o');

        //Hooks
        self::$hooks->filter->add("navbar.menu.inbox", function($value) {
        	return '<span>' . Configuracion::obtain('emails.total') . '</span>';
        });
    }


    public static function install()
    {
        if (!Cronjobs::whereSlug('email')->first()) {
            Cronjobs::create(array(
                'slug' => 'email',
                'programacion' => '*/5 0 0 0 0',
                'class' => 'emailModule',
                'method' => 'Cron',
            ));
        }

        if (!Widgets::whereSlug('email')->first()) {
            Widgets::create([
                'slug' => 'email',
                'titulo' => 'Bandeja de entrada',
                'descripcion' => 'Muestra los últimos emails',
                'class' => 'emailModule',
                'method' => 'Widget',
            ]);
        }


        DB::statement(Utils::createTable(Utils::table(self::$db['table']), self::$db['fields']));
        DB::statement('ALTER TABLE `'.Utils::table(self::$db['table']).'` CHANGE COLUMN `'.self::$db['primary'].'` `'.self::$db['primary'].'` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`'.self::$db['primary'].'`)');
    }

    public static function uninstall()
    {
        DB::statement('DROP TABLE ' . Utils::table(self::$db['table']));

        Cronjobs::whereSlug('email')->delete();
        Widgets::whereSlug('email')->delete();

        Configuracion::remove('emails.total');
    }

    public function configutation()
    {
    }

    public static function sync() {
        Eden::DECORATOR;

        $imap = eden('mail')->imap(
    	'mail.daniellucia.es',
    	'hola@daniellucia.es',
    	'Camarote69',
    	143,
    	false);

        $emails = [
            'mailboxes' => $imap->setActiveMailbox('inbox')->getMailboxes(),
            'mails' =>  $imap->getEmails(0, 50),
            'total' => $imap->getEmailTotal(),
        ];

        foreach ($emails['mails'] as $mailTemp) {
            $body = '';
            if (isset($mailTemp['uid'])) {
                $email = $imap->getUniqueEmails($mailTemp['uid'], true);
                if (isset($email['body'])) {
                    if (isset($email['body']['text/html'])) {
                        $body = $email['body']['text/html'];
                    }
                }

            }
            //echo '<pre>'.print_r($mailTemp, 1).'</pre>';
            $mail = [
                'id_email' => $mailTemp['id'],
                'uid' => $mailTemp['uid'],
                'mailbox' => $mailTemp['mailbox'],
                'user_id' => Session::get('user.id'),
                'title' => $mailTemp['subject'],
                'email_from' => $mailTemp['from']['email'],
                'email_to' => json_encode($mailTemp['to']),
                'body' => $body,
                'date' => date('Y-m-d H:i:s', $mailTemp['date']),
            ];

            $emailDB = Emails::where(['id_email' => $mailTemp['id'], 'uid' => $mailTemp['uid']])->first();
            //echo '<pre>'.print_r($emailDB, 1).'</pre>';
            if (!$emailDB) {
                Emails::create($mail);
            }

        }
        //die();
        Configuracion::set('emails.total', $emails['total']);

        $imap->disconnect();
        Url::redirect(Url::generate('inbox'));
    }

    public static function inbox()
    {

        $title = 'Bandeja de entrada';
        $data = array(
            'title' => $title,
            'emails' => Emails::orderBy('date', 'desc')->get(),
        );

        self::$view->assign($data);
        self::$view->render('index');
    }

    public static function inboxDetail($uid)
    {

        $title = 'Bandeja de entrada';
        $data = array(
            'title' => $title,
            'email' => Emails::whereUid(intval($uid))->where('user_id', Session::get('user.id'))->first(),
        );

        self::$view->assign($data);
        self::$view->render('detail');
    }

    public static function Widget() {

    }
}
