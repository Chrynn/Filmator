<?php declare(strict_types = 1);

namespace App\Module\User;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Path\PathFacade;
use App\Module\ModulePresenter;


class UserPresenter extends ModulePresenter
{

	private AuthorizationFacade $authorizationFacade;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
	)
	{
		parent::__construct($authorizationFacade);
		$this->authorizationFacade = $authorizationFacade;
	}

	protected function startup(): void
	{
		parent::startup();
		if (!$this->authorizationFacade->isLoggedIn()) {
			$this->redirect(":Ghost:Homepage:");
		}
	}

}
