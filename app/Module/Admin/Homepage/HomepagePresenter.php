<?php declare(strict_types=1);

namespace App\Module\Admin\Homepage;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\Admin\AdminPresenter;

class HomepagePresenter extends AdminPresenter
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

