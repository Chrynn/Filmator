<?php declare(strict_types=1);

namespace App\Model\Facade\User\Last;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Database\Entity\MovieLastEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class MovieLastFacade extends AbstractFacade
{

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager
	) {
		parent::__construct($authorizationFacade, $entityManager);
	}


	public function markLast(MovieEntity $movie): void
	{
		$user = $this->getLoggedUser();

		$articleVisitedEntity = new MovieLastEntity();
		$articleVisitedEntity->setMovie($movie);
		$articleVisitedEntity->setUser($user);

		$this->saveEntity($articleVisitedEntity);
	}

}