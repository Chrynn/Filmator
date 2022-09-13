<?php declare(strict_types = 1);

namespace App\Module\Ghost\_component\Register;

use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\Auth\InputCheckFacade;
use App\Model\Service\NeedToChange\Auth;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\Passwords;


final class Register extends Control
{

	/** @var array<callable> */
	public array $onRegister = [];

	private InputCheckFacade $inputCheckFacade;
	private Auth $auth;

	public function __construct(
		InputCheckFacade $inputCheckFacade,
		Auth $auth
	)
	{
		$this->inputCheckFacade = $inputCheckFacade;
		$this->auth = $auth;
	}

	protected function createComponentForm(): Form
	{
		$form = new Form();
		$form->addText("name");
		$form->addText("email");
		$form->addPassword("password");
		$form->addPassword("passwordAgain");
		$form->addSubmit("register");
		$form->onSubmit[] = [$this, "registrationCheck"];
		return $form;
	}

	public function registrationCheck(Form $form): void
	{
		if ($this->inputCheckFacade->registerChecked($form)) {
			try {
				$this->auth->setNewUser($form);
				$this->onRegister();
			} catch (AuthenticationException $e) {
				$form->addError("Registrace nebyla úspěšná");
				$this->redrawControl("register");
			}
		}
		else{
			$this->redrawControl("register");
		}
	}

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . '/templates/register.latte');
		$this->getTemplate()->render();
	}

}
