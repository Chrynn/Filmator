<?php declare(strict_types = 1);

namespace App\Module\User\MovieLike;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\User\UserPresenter;
use Exception;

class MovieLikePresenter extends UserPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		private readonly AuthorizationFacade $authorizationFacade,
	) {
		parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade
		);
	}


	/**
	 * @throws Exception
	 */
	public function actionDefault(): void
	{
		$likeMovies = $this->authorizationFacade->getLoggedUser()->getLikeMovie();
		$this->getTemplate()->movies = $likeMovies->isEmpty() ? [] : $likeMovies;
	}

}

