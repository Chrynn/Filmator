<?php declare(strict_types = 1);

namespace App\Model\Facade\User\ButtonLike;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LikeSerialFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


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
