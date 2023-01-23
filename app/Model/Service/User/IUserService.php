<?php declare(strict_types = 1);

namespace App\Model\Service\User;

use App\Model\Database\Entity\UserEntity;
use Nette\Application\UI\Form;

interface IUserService
{

	public function add(Form $form): void;

	public function getUserById(int $userId): ?UserEntity;

	public function getUserByNickname(string $nickname): ?UserEntity;

	public function getUserByEmail(string $email): ?UserEntity;

}
