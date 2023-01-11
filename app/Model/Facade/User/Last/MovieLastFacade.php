<?php declare(strict_types=1);

namespace App\Model\Facade\User\Last;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Database\Entity\MovieLastEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class MovieLastFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function markLast(MovieEntity $movie): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		$articleVisitedEntity = new MovieLastEntity();
		$articleVisitedEntity->setMovie($movie);
		$articleVisitedEntity->setUser($user);


		$this->entityManager->persist($articleVisitedEntity);
		$this->entityManager->flush();
	}

}