<?php declare(strict_types = 1);

namespace App\Module\Admin;

use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\ModulePresenter;

abstract class AdminPresenter extends ModulePresenter
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
		if ($logged) {
			$admin = $this->authorizationFacade->getLoggedUser()->getRole() === "admin";
			if (!$admin) {
				$this->redirect(":User:Homepage:");
			}
		} else {
			$this->redirect(":Anonymous:Homepage:");
		}
	}

}
