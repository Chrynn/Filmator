<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Like;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class ActorLikeFacade extends AbstractFacade
{

	protected readonly UserEntity $user;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	) {
		parent::__construct($authorizationFacade, $entityManager);

		$this->user = $this->getLoggedUser();
	}


	public function markLike(ActorEntity $actor): void
	{
		$user = $this->user;

		if ($actor->getLikeUser()->contains($user)) {
			return;
		}

		$actor->getLikeUser()->add($user);
		$user->getLikeActor()->add($actor);

		$this->flush();
	}


	public function unmarkLike(ActorEntity $actor): void
	{
		$user = $this->user;

		if (!$actor->getLikeUser()->contains($user)) {
			return;
		}

		$actor->getLikeUser()->removeElement($user);
		$user->getLikeActor()->removeElement($actor);

		$this->flush();
	}


	public function isMarkedLike(ActorEntity $actor): bool
	{
		return $actor->getLikeUser()->contains($this->user);
	}

}
