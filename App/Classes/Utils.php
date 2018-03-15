<?php
namespace Escuchable\App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Utils extends App
{
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
        $format = 'CREATE TABLE %s (%s)';

        foreach ($fields as $field) {
            $buffer[] = $field[0] . ' ' . $field[1];
        }

        $buffer = implode('; ', $buffer);
        $result = sprintf($format, $name, $buffer);
        $result = str_replace(';', ',', $result);

        return $result;
    }
}
