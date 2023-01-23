<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Later;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LaterMovieFacade extends AbstractFacade
{

	protected readonly UserEntity $user;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	) {
		parent::__construct($authorizationFacade, $entityManager);
		$this->user = $this->getLoggedUser();
	}


	public function markLater(MovieEntity $movie): void
	{
		$user = $this->user;

		if ($movie->getLaterUser()->contains($user)) {
			return;
		}

		$movie->getLaterUser()->add($user);
		$user->getLaterMovie()->add($movie);

		$this->flush();
	}


	public function unmarkLater(MovieEntity $movie): void
	{
		$user = $this->user;

		if (!$movie->getLaterUser()->contains($user)) {
			return;
		}

		$movie->getLaterUser()->removeElement($user);
		$user->getLaterMovie()->removeElement($movie);

		$this->flush();
	}


	public function isMarkedLater(MovieEntity $movie): bool
	{
		return $movie->getLaterUser()->contains($this->user);
	}

}
