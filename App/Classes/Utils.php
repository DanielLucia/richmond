<?php
namespace Escuchable\App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Database\Capsule\Manager as DB;

class Utils extends App
{
    private static $secret_key = '^qAe2pQzbSxu|K8U]G7{wKW@D;@:*+gqb5zA5X-O';
    private static $secret_iv = 'WXgm+CpOT8sGf1}rFJ38I7xEm[5~CWV]ZrEeWmpc';

    public static function formatDate($date, $format = 'd/m/Y')
    {
        $date = new \DateTime($date);
        return $date->format($format);
    }

    public function email($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            if (is_array($body)) {
                self::$view->assign($body['content']);
                $body = self::$view->render('Mails/' . $body['template'], true);
            }

            //Server settings
            $mail->isSMTP();

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->Host = getenv('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('MAIL');
            $mail->Password = getenv('MAIL_PASS');
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom(getenv('MAIL'), getenv('MAIL_NAME'));
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            return $mail->send();
        } catch (Exception $e) {
            self::$logger->error($mail->ErrorInfo);
        }
    }

    public static function rSearch($folder, $file)
    {
        echo '<pre>'.$folder . '*.php'.'</pre>';

        $iterator = new \RecursiveDirectoryIterator('.');
        $filter = new \RegexIterator($iterator->getChildren(), '/t.(php|dat)$/');
        $filelist = array();
        foreach ($filter as $entry) {
            $filelist[] = $entry->getFilename();
            echo '<pre>'.$entry->getFilename() .'</pre>';
        }
    }

    /**
    * Obtiene un string quitando espacios, acentos...
    * @param string texto
    * @return string
    */
    public static function slug($string)
    {
        $string = strip_tags($string);
        $characters = array(
            "Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u",
            "á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u",
            "à" => "a", "è" => "e", "ì" => "i", "ò" => "o", "ù" => "u"
          );
        $string = strtr($string, $characters);
        $string = strtolower(trim($string));
        $string = preg_replace("/[^a-z0-9-]/", "-", $string);
        $string = preg_replace("/-+/", "-", $string);
        if (substr($string, strlen($string) - 1, strlen($string)) === "-") {
            $string = substr($string, 0, strlen($string) - 1);
        }
        return $string;
    }

    public static function createTable($name, $fields)
    {
        $format = 'CREATE TABLE `%s` (%s)';
        $buffer = array();
        if (!empty($fields)) {
            foreach ($fields as $key => $field) {
                $buffer[] = '`'.$key . '` ' . $field;
            }

            $buffer = implode('; ', $buffer);
            $result = sprintf($format, $name, $buffer);
            $result = str_replace(';', ',', $result);

            return $result;
        }

        return false;

    }

    public static function table($table) {
        return getenv('DB_PREFIX').$table;
    }

    public static function crypt( $string ) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', self::$secret_key );
        $iv = substr( hash( 'sha256', self::$secret_iv ), 0, 16 );

        return base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }

    public static function decrypt( $string ) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', self::$secret_key );
        $iv = substr( hash( 'sha256', self::$secret_iv ), 0, 16 );
        return openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }

    public static function hasTable($table) {
        return DB::select('show tables like "' . Utils::table($table).'"');
    }

    public static function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }
}
