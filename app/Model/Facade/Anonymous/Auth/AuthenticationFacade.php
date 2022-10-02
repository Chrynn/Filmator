<?php declare(strict_types = 1);

namespace App\Model\Facade\Anonymous\Auth;

use App\Model\Database\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;

final class AuthenticationFacade implements Authenticator
{

	private EntityManagerInterface $entityManager;
	private Passwords $passwords;


	public function __construct(EntityManagerInterface $entityManager, Passwords $passwords)
	{
		$this->entityManager = $entityManager;
		$this->passwords = $passwords;
	}


	public function authenticate(string $user, string $password): IIdentity
	{
		$userEntity = $this->entityManager->getRepository(UserEntity::class)->findOneBy([
			'email' => $user,
		]);

		if ($userEntity === null) {
			throw new AuthenticationException('Uživatel neexistuje');
		}
		if ($userEntity->getPassword() === null) {
			throw new AuthenticationException('Uživatel nemá nastavené heslo.');
		}
		if (!$this->passwords->verify($password, $userEntity->getPassword())) {
			throw new AuthenticationException('Heslo není platné');
		}

		return new UserIdentityFacade($userEntity->getId());
	}

}
