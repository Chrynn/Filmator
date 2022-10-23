<?php declare(strict_types=1);

namespace App\Module\User\MovieLater;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\User\UserPresenter;
use Doctrine\ORM\EntityManagerInterface;

class MovieLaterPresenter extends UserPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		private readonly AuthorizationFacade $authorizationFacade
	)
	{
		parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade
		);
	}


	public function actionDefault(): void
	{
		$laterMovies = $this->authorizationFacade->getLoggedUser()->getLaterMovie();
		$this->getTemplate()->movies = $laterMovies->isEmpty() ? [] : $laterMovies;
	}

}
