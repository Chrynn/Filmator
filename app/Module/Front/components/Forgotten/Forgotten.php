<?php declare(strict_types = 1);

namespace App\Module\Front\components\Forgotten;

use App\Model\Facade\Front\EmailForgotten\EmailForgottenFacade;
use App\Model\Facade\Front\InputCheck\InputCheckFacade;
use App\Model\FlashMessage;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

final class Forgotten extends Control
{

	private const MAIL_SENT_FROM = "helper@filmator.cz";
	private const MAIL_SENT_SUBJECT = "Zapomenuté heslo";

	private const FORGOTTEN_ERROR = "E-mail se nepodařilo odeslat";
	private const FORGOTTEN_SUCCESS = "E-mail byl odeslán";

	/** @var array<callable> */
	public array $onForgotten = [];


	public function __construct(
		private readonly InputCheckFacade $inputCheckFacade,
		private readonly EmailForgottenFacade $emailForgottenFacade
	) {}


	protected function createComponentForm(): Form
	{
		$form = new Form();
		$form->addText("email");
		$form->addSubmit("sent");
		$form->onSubmit[] = [$this, "dataCheck"];
		return $form;
	}


	public function dataCheck(Form $form): void
	{
		$sendTo = $form->getValues()->email;
		$template = $this->createTemplate();
		$html = $template->renderToString(__DIR__ . "/templates/mail.latte");

		$dataReady = $this->inputCheckFacade->forgottenCheck($form);
		if ($dataReady) {
			try {
				$this->emailForgottenFacade->sentEmail(self::MAIL_SENT_FROM, $sendTo, self::MAIL_SENT_SUBJECT, $html);
				$this->flashMessage(self::FORGOTTEN_SUCCESS, FlashMessage::TYPE_SUCCESS);
				$this->redrawControl("forgotten");
				$form->reset();
				$this->onForgotten();
			} catch (AuthenticationException $e) {
				$this->flashMessage(self::FORGOTTEN_ERROR, FlashMessage::TYPE_WARNING);
				$this->redrawControl("forgotten");
			}
		} else {
			$this->redrawControl("forgotten");
		}
	}


	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . '/templates/forgotten.latte');
		$this->getTemplate()->render();
	}

}
