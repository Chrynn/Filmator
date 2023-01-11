<?php declare(strict_types = 1);

namespace App\Model\Facade\Front\EmailForgotten;

interface IEmailForgottenFacade
{

	public function sentEmail(string $from, string $to, string $subject, string $content): void;

}
