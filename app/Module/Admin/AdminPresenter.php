<?php

namespace App\Module\Admin;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Module\Ghost\_component\Login\LoginFactory;
use App\Module\Ghost\_component\Register\RegisterFactory;

abstract class AdminPresenter extends \App\Module\ModulePresenter
{


	private AuthorizationFacade $authorizationFacade;

	public function __construct(AuthorizationFacade $authorizationFacade, LoginFactory $loginFactory, RegisterFactory $registerFactory)
	{
		parent::__construct($authorizationFacade);
		$this->authorizationFacade = $authorizationFacade;
	}

	protected function startup(): void
	{
		parent::startup();
		if ($this->authorizationFacade->isLoggedIn()) {
			if($this->authorizationFacade->getLoggedUser()->getAdminRole())
			{
				$this->redirect(":Admin:Homepage:");
			}
			elseif(!$this->authorizationFacade->getLoggedUser()->getAdminRole())
			{
				$this->redirect(":User:Homepage:");
			}
		}
		else {
			$this->redirect(":Ghost:Login:");
		}
	}

}
