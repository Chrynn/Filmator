<?php declare(strict_types = 1);

namespace App\Model\Facade\Auth;

use App\Model\Database\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Nette\Security\IIdentity;
use Nette\Security\User as NetteSecurityUser;


final class AuthorizationFacade implements IAuthorizationFacade
{

	private EntityManagerInterface $entityManager;
	private NetteSecurityUser $netteSecurityUser;


	public function __construct(
		EntityManagerInterface $entityManager,
		NetteSecurityUser $netteSecurityUser,
	)
	{
		$this->entityManager = $entityManager;
		$this->netteSecurityUser = $netteSecurityUser;
	}


	public function login(string $user, string $password): void
	{
		$this->netteSecurityUser->login($user, $password);
	}


	public function logout(bool $clearIdentity = false): void
	{
		$this->netteSecurityUser->logout($clearIdentity);
	}


	public function isLoggedIn(): bool
	{
		$isLoggedIn = $this->netteSecurityUser->isLoggedIn();
		return $isLoggedIn && $this->getIdentity() instanceof UserIdentityFacade;
	}


	public function getIdentity(): ?IIdentity
	{
		return $this->netteSecurityUser->getIdentity();
	}


	public function getLoggedUser(): UserEntity
	{
		if (!$this->netteSecurityUser->isLoggedIn()) {
			throw new Exception('User is not logged');
		}

		$user = $this->entityManager->createQueryBuilder()
			->select('u')
			->from(UserEntity::class, 'u')
			->where('u.id = :id')
			->setParameter('id', $this->netteSecurityUser->getId())
			->getQuery()
			->getOneOrNullResult();

		if ($user === null) {
			throw new Exception('User is not exists');
		}

		return $user;
	}

}