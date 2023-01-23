<?php declare(strict_types = 1);

namespace App\Module\Admin;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\ModulePresenter;

abstract class AdminPresenter extends ModulePresenter
{

	public function __construct(
		protected readonly PermanentLoginFacade $permanentLoginFacade,
		protected readonly AuthorizationFacade $authorizationFacade
	) {
		parent::__construct(
			$permanentLoginFacade,
			$authorizationFacade
		);
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
			$this->redirect(":Front:Homepage:");
		}
	}

}
