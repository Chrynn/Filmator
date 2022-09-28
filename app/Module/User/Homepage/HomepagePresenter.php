<?php declare(strict_types = 1);

namespace App\Module\User\Homepage;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Path\PathFacade;
use App\Module\User\UserPresenter;


class HomepagePresenter extends UserPresenter
{

	public function __construct(AuthorizationFacade $authorizationFacade)
	{
		parent::__construct($authorizationFacade);
	}

}
