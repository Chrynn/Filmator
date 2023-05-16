<?php declare(strict_types = 1);

namespace App\Model\Facade\Front\InputCheck;

use App\Model\Service\User\UserService;
use Nette\Application\UI\Form;
use Nette\Utils\Validators;

final class InputCheckFacade implements IInputCheckFacade
{

	public function __construct(
		private readonly UserService $userService
	) {}


	public function checkEmail(string $email): bool
	{
		$result = Validators::isEmail($email);
		if (!$result) {
			return false;
		}

		return true;
	}


	public function checkValue(string $value): bool
	{
		$result = Validators::isNone($value);
		if ($result) {
			return false;
		}

		return true;
	}


	public function passwordSame(string $password, string $passwordAgain): bool
	{
		if ($password !== $passwordAgain) {
			return false;
		}

		return true;
	}


	public function nicknameUsed(string $nickname): bool
	{
		$user = $this->userService->getUserByNickname($nickname);
		if ($user) {
			return true;
		}

		return false;
	}


	public function hasLength(string $password): bool
	{
		$result = Validators::is($password, "string:7..");
		if (!$result) {
			return false;
		}

		return true;
	}


	public function hasNumber(string $password): bool
	{
		$result = preg_match("/\d/", $password);
		if (!$result) {
			return false;
		}

		return true;
	}


	public function hasCapitalLetter(string $password): bool
	{
		$result = preg_match("/[A-Z]/", $password);
		if (!$result) {
			return false;
		}

		return true;
	}


	public function hasSmallLetter(string $password): bool
	{
		$result = preg_match("/[a-z]/", $password);
		if (!$result) {
			return false;
		}

		return true;
	}


	public function conditionsChecked(bool $checkBox): bool
	{
		if ($checkBox) {
			return true;
		}

		return false;
	}


	public function loginChecked(Form $form): bool
	{
		$values = $form->getValues();
		$email = $values->email;
		$password = $values->password;

		if (!$this->checkValue($email) && !$this->checkValue($password)) {
			$form["email"]->addError(EInputCheckFacade::emailRequired->value);
			$form["password"]->addError(EInputCheckFacade::passwordRequired->value);

			return false;
		} else if (!$this->checkValue($email)) {
			$form["email"]->addError(EInputCheckFacade::emailRequired->value);

			return false;
		} else if (!$this->checkEmail($email)) {
			$form["email"]->addError(EInputCheckFacade::emailFormat->value);

			return false;
		} else if (!$this->checkValue($password)) {
			$form["password"]->addError(EInputCheckFacade::passwordRequired->value);

			return false;
		}

		return true;
	}


	public function registerChecked(Form $form): bool
	{
		$values = $form->getValues();
		$nickname = $values->nickname;
		$email = $values->email;
		$password = $values->password;
		$passwordAgain = $values->passwordAgain;
		$conditions = $values->conditions;

		if (!$this->checkValue($nickname) && !$this->checkValue($email) && !$this->checkValue($password) && !$this->checkValue($passwordAgain)) {
			$form["nickname"]->addError(EInputCheckFacade::nicknameRequired->value);
			$form["email"]->addError(EInputCheckFacade::emailRequired->value);
			$form["password"]->addError(EInputCheckFacade::passwordRequired->value);
			$form["passwordAgain"]->addError(EInputCheckFacade::passwordAgain->value);

			return false;
		} else if (!$this->checkValue($nickname)) {
			$form["nickname"]->addError(EInputCheckFacade::nicknameRequired->value);

			return false;
		} else if ($this->nicknameUsed($nickname)) {
			$form["nickname"]->addError(EInputCheckFacade::nicknameTaken->value);

			return false;
		} else if (!$this->checkValue($email)) {
			$form["email"]->addError(EInputCheckFacade::emailRequired->value);

			return false;
		} else if (!$this->checkEmail($email)) {
			$form["email"]->addError(EInputCheckFacade::emailFormat->value);

			return false;
		} else if (!$this->checkValue($password)) {
			$form["password"]->addError(EInputCheckFacade::passwordRequired->value);

			return false;
		} else if (!$this->hasLength($password)) {
			$form["password"]->addError(EInputCheckFacade::passwordLength->value);

			return false;
		} else if (!$this->hasNumber($password)) {
			$form["password"]->addError(EInputCheckFacade::passwordNumber->value);

			return false;
		} else if (!$this->hasCapitalLetter($password)) {
			$form["password"]->addError(EInputCheckFacade::passwordCapital->value);

			return false;
		} else if (!$this->hasSmallLetter($password)) {
			$form["password"]->addError(EInputCheckFacade::passwordSmall->value);

			return false;
		} else if (!$this->checkValue($passwordAgain)) {
			$form["passwordAgain"]->addError(EInputCheckFacade::passwordAgain->value);

			return false;
		} else if (!$this->passwordSame($password, $passwordAgain)) {
			$form->addError(EInputCheckFacade::passwordSame->value);
			$form["password"]->addError("");
			$form["passwordAgain"]->addError("");

			return false;
		} else if (!$this->conditionsChecked($conditions)) {
			$form->addError(EInputCheckFacade::conditionsRequired->value);
			$form["conditions"]->addError("");

			return false;
		}

		return true;
	}


	public function forgottenCheck(Form $form): bool
	{
		$values = $form->getValues();
		$email = $values->email;

		if (!$this->checkValue($email)) {
			$form["email"]->addError(EInputCheckFacade::emailRequired->value);

			return false;
		} else if (!$this->checkEmail($email)) {
			$form["email"]->addError(EInputCheckFacade::emailFormat->value);

			return false;
		}

		return true;
	}

}
