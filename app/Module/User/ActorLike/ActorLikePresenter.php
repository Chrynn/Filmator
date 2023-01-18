<?php declare(strict_types=1);

namespace App\Module\User\ActorLike;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\ModulePresenter;
use Exception;

class ActorLikePresenter extends ModulePresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade
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
		$this->getTemplate()->actors = $this->getLoggedUser()->getLikeActor()->toArray();
	}

}