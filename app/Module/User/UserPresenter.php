<?php declare(strict_types = 1);

namespace App\Module\User;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\ModulePresenter;

class UserPresenter extends ModulePresenter
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


	protected function startup(): void
	{
		parent::startup();
		if (!$this->isLogged()) {
			$this->redirect(":Front:Homepage:");
		}
	}

}
