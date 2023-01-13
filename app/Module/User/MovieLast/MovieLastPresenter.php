<?php declare(strict_types=1);

namespace App\Module\User\MovieLast;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Movie\MovieService;
use App\Module\User\UserPresenter;
use Exception;

class MovieLastPresenter extends UserPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		private readonly MovieService $movieService
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
        $loggedUser = $this->getLoggedUser();

		$this->getTemplate()->movies = $this->movieService->getMoviesLastByUser($loggedUser);
	}

}
