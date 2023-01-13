<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Like;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class MovieLikeFacade extends AbstractFacade
{

	protected readonly UserEntity $user;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	) {
		parent::__construct($authorizationFacade, $entityManager);
		$this->user = $this->getLoggedUser();
	}


	public function markLike(MovieEntity $movie): void
	{
		$user = $this->user;

		if ($movie->getLikeUser()->contains($user)) {
			return;
		}

		$movie->getLikeUser()->add($user);
		$user->getLikeMovie()->add($movie);

		$this->flush();
	}


	public function unmarkLike(MovieEntity $movie): void
	{
		$user = $this->user;

		if (!$movie->getLikeUser()->contains($user)) {
			return;
		}

		$movie->getLikeUser()->removeElement($user);
		$user->getLikeMovie()->removeElement($movie);

		$this->flush();
	}


	public function isMarkLike(MovieEntity $movie): bool
	{
		return $movie->getLikeUser()->contains($this->user);
	}

}
