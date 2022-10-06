<?php declare(strict_types = 1);

namespace App\Module\Anonymous\components\Register;

use App\Model\Facade\Anonymous\InputCheck\InputCheckFacade;
use App\Model\Service\User\UserService;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

final class Register extends Control
{

	private const REGISTER_ERROR = "Registrace nebyla úspěšná";
	private const REGISTER_SUCCESS = "Registrace byla úspěšná, můžete se přihlásit";

	/** @var array<callable> */
	public array $onRegister = [];


	public function __construct(
		private readonly InputCheckFacade $inputCheckFacade,
		private readonly UserService $userService
	) {}


	protected function createComponentForm(): Form
	{
		$form = new Form();
		$form->addText("nickname");
		$form->addText("email");
		$form->addPassword("password");
		$form->addPassword("passwordAgain");
		$form->addCheckbox("conditions");
		$form->addCheckbox("newsletter");
		$form->addSubmit("register");
		$form->onSubmit[] = [$this, "registrationCheck"];
		return $form;
	}


	public function registrationCheck(Form $form): void
	{
		if ($this->inputCheckFacade->registerChecked($form)) {
			try {
				$this->userService->add($form);
				$this->flashMessage(self::REGISTER_SUCCESS);
				$this->redrawControl("register");
				$form->reset();
				$this->onRegister();
			} catch (AuthenticationException $e) {
				$form->addError(self::REGISTER_ERROR);
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
