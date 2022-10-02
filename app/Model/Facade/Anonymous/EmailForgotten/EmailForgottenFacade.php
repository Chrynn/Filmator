<?php declare(strict_types = 1);

namespace App\Model\Facade\Anonymous\EmailForgotten;

use Nette\Mail\Message;

final class EmailForgottenFacade
{

	private \Nette\Mail\Mailer $mailer; // this package is not extension, only class addition


	public function __construct(\Nette\Mail\Mailer $mailer)
	{
		$this->mailer = $mailer;
	}


	public function sentEmail(string $from, string $to, string $subject, string $content): void
	{
		$mail = new Message();
		$mail->setFrom($from);
		$mail->setSubject($subject);
		$mail->addTo($to);
		// setBody() - text
		// setHtmlBody() - html
		$mail->setHtmlBody($content);

		$this->mailer->send($mail);
	}

}
