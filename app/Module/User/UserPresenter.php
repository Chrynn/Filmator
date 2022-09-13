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
		PathFacade $pathFacade,
	)
	{
		parent::__construct($authorizationFacade, $pathFacade);
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
