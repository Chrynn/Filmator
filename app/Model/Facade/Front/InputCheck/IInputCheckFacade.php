<?php declare(strict_types = 1);

namespace App\Model\Facade\Front\InputCheck;

use Nette\Application\UI\Form;

interface IInputCheckFacade
{

	public function checkEmail(string $email): bool;

	public function checkValue(string $value): bool;

	public function passwordSame(string $password, string $passwordAgain): bool;

	public function nicknameUsed(string $nickname): bool;

	public function hasLength(string $password): bool;

	public function hasNumber(string $password): bool;

	public function hasCapitalLetter(string $password): bool;

	public function hasSmallLetter(string $password): bool;

	public function conditionsChecked(bool $checkBox): bool;

	public function loginChecked(Form $form): bool;

	public function registerChecked(Form $form): bool;

	public function forgottenCheck(Form $form): bool;

}
