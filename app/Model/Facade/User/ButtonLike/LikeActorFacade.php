<?php declare(strict_types = 1);

namespace App\Model\Facade\User\ButtonLike;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LikeActorFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function like(ActorEntity $actor): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($actor->getLikeUser()->contains($user)) {
			return;
		}

		$actor->getLikeUser()->add($user);
		$user->getLikeActor()->add($actor);

		$this->entityManager->flush();
	}


	public function dislike(ActorEntity $actor): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$actor->getLikeUser()->contains($user)) {
			return;
		}

		$actor->getLikeUser()->removeElement($user);
		$user->getLikeActor()->removeElement($actor);

		$this->entityManager->flush();
	}


	public function isLiked(ActorEntity $actor): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();
		return $actor->getLikeUser()->contains($user);
	}

}
