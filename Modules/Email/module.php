<?php

/*
Plugin Name: Email
Slug: email
Description: Permite leer emails dentro del sistema
Version: 0.0.1
Author: daniellucia.es
*/

use Escuchable\App\Modulo;
use Escuchable\App\Request;
use Escuchable\App\Menu;
use Escuchable\App\Utils;
use Escuchable\App\Session;
use Escuchable\App\Url;
use Escuchable\App\Flash;

use Escuchable\Modelos\Emails;
use Escuchable\Modelos\emailsAccount;
use Escuchable\Modelos\Cronjobs;
use Escuchable\Modelos\Widgets;
use Escuchable\Modelos\Configuracion;

use Illuminate\Database\Query\Expression as raw;
use Illuminate\Database\Capsule\Manager as DB;

class emailModule extends Modulo
{
    public function __construct()
    {
        $this->route = __DIR__;
        $this->has_configuration = true;
        self::$modelo = include($this->route . '/.db/model.php');

        //Menu
        Menu::add(1, array('navbar'), 'Bandeja de entrada', 'inbox', 'envelope-o');
        Menu::add(2, array('configuracion'), 'Cuentas de correo', 'emails_accounts');

        //Hooks
        self::$hooks->filter->add("navbar.menu.inbox", function ($value) {
            $totalEmails = Configuracion::obtain('emails.total');
            if ($totalEmails > 0) {
                return '<span>' . $totalEmails . '</span>';
            }
        });
    }


    public static function install()
    {
        parent::install();

        if (!Cronjobs::whereSlug('email')->first()) {
            Cronjobs::create(array(
                'slug' => 'email',
                'programacion' => '*/5 0 * * *',
                'class' => 'emailModule',
                'method' => 'sync',
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
    }

    public static function uninstall()
    {
        parent::uninstall();

        Cronjobs::whereSlug('email')->delete();
        Widgets::whereSlug('email')->delete();

        Configuracion::remove('emails.total');
    }

    public function configuration()
    {
        if (Request::is('post')) {
            $data = Request::post();
            $data['user_id'] = Session::get('user.id');
            $data['password'] = Utils::crypt($data['password']);
            $data['ssl'] = (isset($data['ssl']) && intval($data['ssl']) == 1 ? 1 : 0);

            emailsAccount::create($data);
            Url::redirect(Url::generate('sync_inbox'));
        }

        $title = 'Cuentas de correo';
        $data = array(
            'title' => $title,
            'emailsAccount' => emailsAccount::where('user_id', Session::get('user.id'))->get(),
        );

        self::$view->assign($data);
        self::$view->render('configuration');
    }

    public static function sync($cron = false)
    {
        Eden::DECORATOR;

        $emailsAccounts = emailsAccount::all();
        foreach ($emailsAccounts as $emailAccount) {
            try {
                $imap = eden('mail')->imap(
                $emailAccount->host,
                $emailAccount->account,
                Utils::decrypt($emailAccount->password),
                $emailAccount->port,
                ($emailAccount->ssl == 1 ? true : false)
                );

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
                        'user_id' => $emailAccount->user_id,
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
                //Configuracion::set('emails.total', Emails::whereRead(0)->count());

                $imap->disconnect();
            }
            catch(Exception $e) {
              Flash::set($e->getMessage(), 'error', 'Vaya!');
              Url::redirect(Url::generate('inbox'));
            }
        }


        if (!$cron) {
            Url::redirect(Url::generate('inbox'));
        }
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
        $email = Emails::whereUid(intval($uid))->where('user_id', Session::get('user.id'))->first();
        $data = array(
            'title' => $title,
            'email' => $email,
        );

        Emails::whereUid(intval($uid))->where('user_id', Session::get('user.id'))->update(['leido' => 1]);

        Configuracion::set('emails.total', Emails::whereLeido(0)->count());

        self::$view->assign($data);
        self::$view->render('detail');
    }

    public static function Widget()
    {
        return false;
    }
}
