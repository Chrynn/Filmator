<?php declare(strict_types = 1);

namespace App\Model\Facade\WatchButton;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Auth\LoginFunctions;
use Doctrine\ORM\EntityManagerInterface;


final class WatchMovieFacade
{

	private AuthorizationFacade $authorizationFacade;
	private EntityManagerInterface $entityManager;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	)
	{
		$this->authorizationFacade = $authorizationFacade;
		$this->entityManager = $entityManager;
	}

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
