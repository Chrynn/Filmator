<?php declare(strict_types = 1);

namespace App\Model\Facade\User\ButtonLater;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LaterMovieFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function watch(MovieEntity $movie): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($movie->getWatchUser()->contains($user)) {
			return;
		}

		$movie->getWatchUser()->add($user);
		$user->getWatchMovie()->add($movie);

		$this->entityManager->flush();
	}


	public function unWatch(MovieEntity $movie): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$movie->getWatchUser()->contains($user)) {
			return;
		}

		$movie->getWatchUser()->removeElement($user);
		$user->getWatchMovie()->removeElement($movie);

		$this->entityManager->flush();
	}


	public function wantWatch(MovieEntity $movie): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();
		return $movie->getWatchUser()->contains($user);
	}

}
