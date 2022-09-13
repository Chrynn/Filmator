<?php declare(strict_types = 1);

namespace App\Model\Facade\LikeButton;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Auth\LoginFunctions;
use Doctrine\ORM\EntityManagerInterface;


final class LikeSerialFacade
{

	private AuthorizationFacade $authorizationFacade;
	private EntityManagerInterface $entityManager;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager
	)
	{
		$this->authorizationFacade = $authorizationFacade;
		$this->entityManager = $entityManager;
	}

	public function like(SerialEntity $serial): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($serial->getLikeUser()->contains($user)) {
			return;
		}

		$serial->getLikeUser()->add($user);
		$user->getLikeSerial()->add($serial);

		$this->entityManager->flush();
	}

	public function dislike(SerialEntity $serial): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$serial->getLikeUser()->contains($user)) {
			return;
		}

		$serial->getLikeUser()->removeElement($user);
		$user->getLikeSerial()->removeElement($serial);

		$this->entityManager->flush();
	}

	public function isLiked(SerialEntity $serial): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();
		return $serial->getLikeUser()->contains($user);
	}

}
