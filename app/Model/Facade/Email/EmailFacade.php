<?php declare(strict_types = 1);

namespace App\Model\Facade\Email;

use Nette\Mail\Message;


final class EmailFacade
{
	// this package is not extension, only class addition
	private \Nette\Mail\Mailer $mailer;

	public function __construct(\Nette\Mail\Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function sentEmail(string $from, string $to, string $content): void
	{
		$mail = new Message();
		$mail->setFrom($from);
		$mail->addTo($to);
		// setBody() - text, setHtmlBody() - html
		$mail->setHtmlBody($content);

		$this->mailer->send($mail);

	}

}
