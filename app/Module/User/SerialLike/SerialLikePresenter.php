<?php declare(strict_types=1);

namespace App\Module\User\SerialLike;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\User\UserPresenter;
use Exception;

class SerialLikePresenter extends UserPresenter
{

	public function __construct(
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade
	) {
		parent::__construct(
			$permanentLoginFacade,
			$authorizationFacade
		);
	}


	/**
	 * @throws Exception
	 */
	public function actionDefault(): void
	{
		$this->getTemplate()->serials = $this->getLoggedUser()->getLikeSerial()->toArray();
	}

}
