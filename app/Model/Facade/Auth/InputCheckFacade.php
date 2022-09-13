<?php declare(strict_types = 1);

namespace App\Model\Facade\Auth;

use Nette\Application\UI\Form;


final class InputCheckFacade
{

	const MESSAGE_EMAIL_FORMAT = "Špatný E-mail formát";
	const MESSAGE_EMAIL = "Vyplňte E-mail";
	const MESSAGE_PASSWORD = "Vyplňte Heslo";

	/**
	 *	@return bool (matching regex: true, else: false)
	 */
	public function checkEmail(string $text): bool
	{
		// PHP regex string need delimiters
		$pattern = "/^[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,3}$/";
		$result = preg_match($pattern, $text);
		$matching = 1;

		if ($result === $matching) {
			return true;
		}

		return false;
	}
	
	public function loginChecked(Form $form): bool
	{
		$value = $form->getValues();

		if ($value->email === "" && $value->password === "") {
			$form["email"]->addError(self::MESSAGE_EMAIL);
			$form["password"]->addError(self::MESSAGE_PASSWORD);
			return false;

		} elseif ($value->email === "") {
			$form["email"]->addError(self::MESSAGE_EMAIL);
			return false;

		} elseif ($value->password === "") {
			$form["password"]->addError(self::MESSAGE_PASSWORD);
			return false;

		} elseif ($this->checkEmail($value->email) === false){
			$form["email"]->addError(self::MESSAGE_EMAIL_FORMAT);
			return false;
		}

		return true;
	}

	public function registerChecked(Form $form): bool
	{
		$value = $form->getValues();

		if ($value->email === "" && $value->password === "" && $value->passwordAgain === "") {
			$form["email"]->addError("Vyplňte E-mail");
			$form["password"]->addError("Vyplňte heslo");
			$form["passwordAgain"]->addError("Vyplňte heslo");
			return false;

		} elseif ($value->email === "") {
			$form["email"]->addError("Vyplňte E-mail");
			return false;

		} elseif ($this->checkEmail($value->email) === false){
			$form["email"]->addError("Špatný E-mail formát");
			return false;

		} elseif ($value->password === "") {
			$form["password"]->addError("Vyplňte Heslo");
			return false;

		} elseif ($value->passwordAgain === "") {
			$form["passwordAgain"]->addError("Vyplňte Heslo");
			return false;

		}

		return true;
	}

	public function forgottenCheck(Form $form): bool
	{
		$value = $form->getValues();

		if ($value->email === "") {
			$form["email"]->addError("Vyplňte E-mail");
			return false;

		}
		if ($this->checkEmail($value->email) === false){
			$form["email"]->addError("Špatný E-mail formát");
			return false;

		}

		return true;
	}

}
