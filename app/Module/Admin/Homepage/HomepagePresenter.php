<?php declare(strict_types=1);

namespace App\Module\Admin\Homepage;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Module\Admin\AdminPresenter;

class HomepagePresenter extends AdminPresenter
{

	public function __construct(AuthorizationFacade $authorizationFacade)
	{
		parent::__construct($authorizationFacade);
	}

}

