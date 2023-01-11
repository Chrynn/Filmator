<?php declare(strict_types = 1);

namespace App\Model\Facade\User\ButtonLater;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LaterMovieFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function later(MovieEntity $movie): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($movie->getLaterUser()->contains($user)) {
			return;
		}

		$movie->getLaterUser()->add($user);
		$user->getLaterMovie()->add($movie);

		$this->entityManager->flush();
	}


	public function unLater(MovieEntity $movie): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$movie->getLaterUser()->contains($user)) {
			return;
		}

		$movie->getLaterUser()->removeElement($user);
		$user->getLaterMovie()->removeElement($movie);

		$this->entityManager->flush();
	}


	public function laterMarked(MovieEntity $movie): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();
		return $movie->getLaterUser()->contains($user);
	}

}
