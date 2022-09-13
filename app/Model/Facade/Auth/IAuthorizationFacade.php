<?php declare(strict_types = 1);

namespace App\Model\Facade\Auth;

use App\Model\Database\Entity\UserEntity;
use Nette\Security\IIdentity;

interface IAuthorizationFacade
{

	public function login(string $user, string $password): void;

	public function logout(bool $clearIdentity = false): void;

	public function isLoggedIn(): bool;

	public function getIdentity(): ?IIdentity;

	public function getLoggedUser(): UserEntity;

}
