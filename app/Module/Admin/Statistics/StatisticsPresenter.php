<?php declare(strict_types = 1);

namespace App\Module\Admin\Statistics;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Module\Admin\AdminPresenter;

class StatisticsPresenter extends AdminPresenter
{

	public function __construct(AuthorizationFacade $authorizationFacade)
	{
		parent::__construct($authorizationFacade);
	}

}
