<?php declare(strict_types = 1);

namespace App\Model\Facade\Front\EmailForgotten;

use Nette\Mail\Message;

final class EmailForgottenFacade implements IEmailForgottenFacade
{

	public function __construct(
		private readonly \Nette\Mail\Mailer $mailer // this package is not extension, only class addition
	) {}


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
