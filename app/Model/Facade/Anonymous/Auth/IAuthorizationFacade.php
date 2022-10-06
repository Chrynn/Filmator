<?php declare(strict_types = 1);

namespace App\Model\Facade\Anonymous\Auth;

use App\Model\Database\Entity\UserEntity;
use Nette\Security\IIdentity;

interface IAuthorizationFacade
{

	public function login(string $user, string $password): void;

	public function loginById(int $userId): void;

	public function logout(bool $clearIdentity = false): void;

	public function isLoggedIn(): bool;

	public function getIdentity(): ?IIdentity;

	public function getIdentityById(int $userId): UserIdentityFacade;

	public function getLoggedUser(): UserEntity;

}
