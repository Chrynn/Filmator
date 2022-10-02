<?php declare(strict_types = 1);

namespace App\Model\Facade\Anonymous\Auth;

use App\Model\Service\User\UserService;
use Nette\Application\UI\Form;
use Nette\Utils\Validators;

final class InputCheckFacade
{

	const MESSAGE_NICKNAME = "Zvolte přezdívku";
	const MESSAGE_NICKNAME_USED = "Přezdívka je zabraná";
	const MESSAGE_EMAIL_FORMAT = "Špatný E-mail formát";
	const MESSAGE_EMAIL = "Vyplňte E-mail";
	const MESSAGE_PASSWORD = "Vyplňte Heslo";
	const MESSAGE_PASSWORD_AGAIN = "Vyplňte Heslo znovu";
	const MESSAGE_PASSWORD_SAME = "Hesla se neshodují";
	const MESSAGE_PASSWORD_LENGTH = "Heslo musí mít nad 6 znaků";
	const MESSAGE_PASSWORD_NUMBER = "Heslo musí musí mít číslici";
	const MESSAGE_PASSWORD_CAPITAL = "Heslo musí musí mít velké písmeno";
	const MESSAGE_PASSWORD_SMALL = "Heslo musí musí mít malé písmeno";
	const MESSAGE_CONDITIONS = "Musíte souhlasit s podmínkami";

	private UserService $userService;


	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}


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
			$form["email"]->addError(self::MESSAGE_EMAIL);
			$form["password"]->addError(self::MESSAGE_PASSWORD);

			return false;
		}
		else if (!$this->checkValue($email)) {
			$form["email"]->addError(self::MESSAGE_EMAIL);

			return false;
		}
		else if (!$this->checkEmail($email)) {
			$form["email"]->addError(self::MESSAGE_EMAIL_FORMAT);

			return false;
		}
		else if (!$this->checkValue($password)) {
			$form["password"]->addError(self::MESSAGE_PASSWORD);

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
			$form["nickname"]->addError(self::MESSAGE_NICKNAME);
			$form["email"]->addError(self::MESSAGE_EMAIL);
			$form["password"]->addError(self::MESSAGE_PASSWORD);
			$form["passwordAgain"]->addError(self::MESSAGE_PASSWORD_AGAIN);

			return false;
		}
		else if (!$this->checkValue($nickname)) {
			$form["nickname"]->addError(self::MESSAGE_NICKNAME);

			return false;
		}
		else if ($this->nicknameUsed($nickname)) {
			$form["nickname"]->addError(self::MESSAGE_NICKNAME_USED);

			return false;
		}
		else if (!$this->checkValue($email)) {
			$form["email"]->addError(self::MESSAGE_EMAIL);

			return false;
		}
		else if (!$this->checkEmail($email)) {
			$form["email"]->addError(self::MESSAGE_EMAIL_FORMAT);

			return false;
		}
		else if (!$this->checkValue($password)) {
			$form["password"]->addError(self::MESSAGE_PASSWORD);

			return false;
		}
		else if (!$this->hasLength($password)) {
			$form["password"]->addError(self::MESSAGE_PASSWORD_LENGTH);

			return false;
		}
		else if (!$this->hasNumber($password)) {
			$form["password"]->addError(self::MESSAGE_PASSWORD_NUMBER);

			return false;
		}
		else if (!$this->hasCapitalLetter($password)) {
			$form["password"]->addError(self::MESSAGE_PASSWORD_CAPITAL);

			return false;
		}
		else if (!$this->hasSmallLetter($password)) {
			$form["password"]->addError(self::MESSAGE_PASSWORD_SMALL);

			return false;
		}
		else if (!$this->checkValue($passwordAgain)) {
			$form["passwordAgain"]->addError(self::MESSAGE_PASSWORD_AGAIN);

			return false;
		}
		else if (!$this->passwordSame($password, $passwordAgain)) {
			$form->addError(self::MESSAGE_PASSWORD_SAME);
			$form["password"]->addError("");
			$form["passwordAgain"]->addError("");

			return false;
		}
		else if (!$this->conditionsChecked($conditions)) {
			$form->addError(self::MESSAGE_CONDITIONS);
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
			$form["email"]->addError(self::MESSAGE_EMAIL);

			return false;
		}
		else if (!$this->checkEmail($email)) {
			$form["email"]->addError(self::MESSAGE_EMAIL_FORMAT);

			return false;
		}

		return true;
	}

}
