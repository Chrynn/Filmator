<?php declare(strict_types=1);

namespace App\Module\User\ActorLike;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\ModulePresenter;
use Doctrine\ORM\EntityManagerInterface;

class ActorLikePresenter extends ModulePresenter
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
		$likeActors = $this->authorizationFacade->getLoggedUser()->getLikeActor();
		$this->getTemplate()->actors = $likeActors->isEmpty() ? [] : $likeActors;
	}

}