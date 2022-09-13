<?php declare(strict_types = 1);

namespace App\Module\User\MovieLiked;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Auth\LoginFunctions;
use App\Module\User\UserPresenter;
use Doctrine\ORM\EntityManagerInterface;

class MovieLikedPresenter extends UserPresenter
{

	private AuthorizationFacade $authorizationFacade;
	private EntityManagerInterface $entityManager;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	)
	{
		parent::__construct($authorizationFacade);
		$this->authorizationFacade = $authorizationFacade;
		$this->entityManager = $entityManager;
	}

	public function actionDefault(): void
	{
		// $this->getTemplate()->movies = $this->loggedUserFacade->getLoggedUser()->getLikedMovies();

		$this->getTemplate()->movies = $this->entityManager->createQueryBuilder()
			->select("m")
			->from(MovieEntity::class, "m")
			->join("m.usersLike", "u")
			->where("u = :loggedUser")
			->setParameter("loggedUser", $this->authorizationFacade->getLoggedUser())
			->getQuery()
			->getResult();
	}

}

