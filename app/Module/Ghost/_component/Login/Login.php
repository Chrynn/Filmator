<?php declare(strict_types = 1);

namespace App\Module\Ghost\_component\Login;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Auth\InputCheckFacade;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;


final class Login extends Control
{

	private AuthorizationFacade $authorizationFacade;
	private InputCheckFacade $inputCheckFacade;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		InputCheckFacade $inputCheckFacade
	)
	{
		$this->authorizationFacade = $authorizationFacade;
		$this->inputCheckFacade = $inputCheckFacade;
	}

	/** @var array<callable> */
	public array $onLogin = [];

	protected function createComponentForm(): Form
	{
		$form = new Form();
		$form->addText("email");
		$form->addPassword("password");
		$form->addSubmit("login");
		$form->onSubmit[] = [$this, "loginCheck"];
		return $form;
	}

	public function loginCheck(Form $form): void
	{
		$dataReady = $this->inputCheckFacade->loginChecked($form);
		if ($dataReady) {
			try {
				$this->authorizationFacade->login($form->getValues()->email, $form->getValues()->password);
				$this->onLogin();
			} catch (AuthenticationException $e) {
				$form->addError("Nesprávný E-mail nebo heslo");
				$this->redrawControl("login");
			}
		} else{
			$this->redrawControl("login");
		}
	}

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . '/templates/login.latte');
		$this->getTemplate()->render();
	}

}