<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Like;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class MovieLikeFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function like(MovieEntity $movie): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($movie->getLikeUser()->contains($user)) {
			return;
		}

		$movie->getLikeUser()->add($user);
		$user->getLikeMovie()->add($movie);

		$this->entityManager->flush();
	}


	public function unLike(MovieEntity $movie): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$movie->getLikeUser()->contains($user)) {
			return;
		}

		$movie->getLikeUser()->removeElement($user);
		$user->getLikeMovie()->removeElement($movie);

		$this->entityManager->flush();
	}


	public function isLiked(MovieEntity $movie): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();
		return $movie->getLikeUser()->contains($user);
	}

}
