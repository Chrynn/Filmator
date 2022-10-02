<?php declare(strict_types = 1);

namespace App\Module\User;

use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\ModulePresenter;

class UserPresenter extends ModulePresenter
{

	private AuthorizationFacade $authorizationFacade;

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade
	)
	{
		parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade
		);
		$this->authorizationFacade = $authorizationFacade;
	}


	protected function startup(): void
	{
		parent::startup();
		$logged = $this->authorizationFacade->isLoggedIn();
		if (!$logged) {
			$this->redirect(":Anonymous:Homepage:");
		}
	}

}
