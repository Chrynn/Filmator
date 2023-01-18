<?php declare(strict_types = 1);

namespace App\Module\Front\components\Login;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Front\InputCheck\InputCheckFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

final class Login extends Control
{

	private const LOGIN_ERROR = "Nesprávný E-mail nebo heslo";

	/** @var array<callable> */
	public array $onLogin = [];


	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly InputCheckFacade $inputCheckFacade,
		private readonly PermanentLoginFacade $permanentLoginFacade
	) {}


	protected function createComponentForm(): Form
	{
		$form = new Form();
		$form->addText("email");
		$form->addPassword("password");
		$form->addSubmit("login");
		$form->addCheckbox("remember");
		$form->onSubmit[] = [$this, "loginCheck"];
		return $form;
	}


	public function loginCheck(Form $form): void
	{
		$dataReady = $this->inputCheckFacade->loginChecked($form);
		if ($dataReady) {
			$values = $form->getValues();
			$email = $values->email;
			$password = $values->password;
			$remember = $values->remember;
			try {
				$this->authorizationFacade->login($email, $password);
				if ($remember) {
					$this->permanentLoginFacade->setPermanentLoginCookie($email);
				}
				$this->onLogin();
			} catch (AuthenticationException $e) {
				$form->addError(self::LOGIN_ERROR);
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
