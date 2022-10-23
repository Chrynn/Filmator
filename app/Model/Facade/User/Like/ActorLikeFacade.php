<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Like;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class ActorLikeFacade
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


	public function unLike(ActorEntity $actor): void
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
