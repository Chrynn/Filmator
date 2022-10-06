<?php declare(strict_types = 1);

namespace App\Module\User\MovieLiked;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\User\UserPresenter;
use Doctrine\ORM\EntityManagerInterface;

class MovieLikedPresenter extends UserPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {
		parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade
		);
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

