<?php declare(strict_types = 1);

namespace App\Module\Ghost\_component\Login;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Auth\InputCheckFacade;
use App\Model\Facade\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\User\UserService;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;


final class Login extends Control
{

	private const LOGIN_ERROR = "Nesprávný E-mail nebo heslo";

	/** @var array<callable> */
	public array $onLogin = [];

	private AuthorizationFacade $authorizationFacade;
	private InputCheckFacade $inputCheckFacade;
	private UserService $userService;
	private PermanentLoginFacade $permanentLoginFacade;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		InputCheckFacade $inputCheckFacade,
		UserService $userService,
		PermanentLoginFacade $permanentLoginFacade
	)
	{
		$this->authorizationFacade = $authorizationFacade;
		$this->inputCheckFacade = $inputCheckFacade;
		$this->userService = $userService;
		$this->permanentLoginFacade = $permanentLoginFacade;
	}


	protected function createComponentForm(): Form
	{
		$form = new Form();
		$form->addText("email");
		$form->addPassword("password");
		$form->addSubmit("login");
		$form->addCheckbox("logged");
		$form->onSubmit[] = [$this, "loginCheck"];
		return $form;
	}


	public function loginCheck(Form $form): void
	{
		$dataReady = $this->inputCheckFacade->loginChecked($form);
		$values = $form->getValues();
		$email = $values->email;
		$password = $values->password;
		if ($dataReady) {
			try {
				$this->authorizationFacade->login($email, $password);
				if ($form->getValues()->logged) {
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