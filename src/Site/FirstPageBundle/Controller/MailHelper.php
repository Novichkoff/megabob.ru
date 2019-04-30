<?php
/**
 * Created by PhpStorm.
 * User: Новичков
 * Date: 23.09.14
 * Time: 10:11
 */
namespace Site\FirstPageBundle\Controller;

class MailHelper
{
    function sendMailing($from, $to, $subject, $body) {
        if (!$from || !$to || !$subject || !$body) {return false;}
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: '. $from . "\r\n";
		$headers .= "Return-Path: <admin@megabob.ru>"."\n";
		$headers .= "Errors-To: <admin@megabob.ru>"."\n";
        $headers .= 'Precedence: bulk' . "\r\n";
        $headers .= 'List-Unsubscribe: <https://www.megabob.ru/unsubscribe_page?email='.$to.'>'. "\r\n";
        return mail($to, $this->code_mail_subject($subject), $body, $headers);
    }

    function code_mail_subject($subject) {
        return '=?UTF-8?B?'. base64_encode($subject) .'?=';
    }
}