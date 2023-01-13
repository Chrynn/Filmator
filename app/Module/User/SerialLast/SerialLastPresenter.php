<?php declare(strict_types=1);

namespace App\Module\User\SerialLast;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Serial\SerialService;
use App\Module\User\UserPresenter;
use Exception;

class SerialLastPresenter extends UserPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		private readonly SerialService $serialService
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

		$this->getTemplate()->serials = $this->serialService->getSerialsLastByUser($loggedUser);
	}

}
