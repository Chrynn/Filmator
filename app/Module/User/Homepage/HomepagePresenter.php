<?php declare(strict_types = 1);

namespace App\Module\User\Homepage;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\User\UserPresenter;

class HomepagePresenter extends UserPresenter
{

	public function __construct(
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade
	)
	{
		parent::__construct(
			$permanentLoginFacade,
			$authorizationFacade
		);
	}

}
