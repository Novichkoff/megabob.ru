<?php

namespace Site\FirstPageBundle\Controller;


use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Mailer
{
    	
    private $generator;
	public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }
	
    function sendConfirmationEmailMessage(UserInterface $user) {
		$from = 'MegaBob <info@megabob.ru>';
		$to = $user->getEmail();
		$subject = 'Подтверждение Email на MegaBob';		
			
		$url = $this->generator->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), true);
		
		$body = 'Для подтверждения аккаунта перейдите по <a href="https://www.megabob.ru/resseting/reset/'.$url.'">ссылке</a>';
		$this->sendMailing($from, $to, $subject, $body);
	}    
    function sendResettingEmailMessage(UserInterface $user) {
		$from = 'MegaBob <info@megabob.ru>';
		$to = $user->getEmail();
		$subject = 'Сброс пароля на MegaBob';
			
		$url = $this->generator->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true);
				
		$body = 'Для сброса пароля перейдите по <a href="https://www.megabob.ru/resseting/reset/'.$url.'">ссылке</a>';
		$this->sendMailing($from, $to, $subject, $body);
	}
	function sendMailing($from, $to, $subject, $body) {
        if (!$from || !$to || !$subject || !$body) {return false;}
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: '. $from . "\r\n";
        return mail($to, $this->code_mail_subject($subject), $body, $headers);
    }

    function code_mail_subject($subject) {
        return '=?UTF-8?B?'. base64_encode($subject) .'?=';
    }
}