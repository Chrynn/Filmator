<?php declare(strict_types=1);

namespace App\Module\User\MovieLast;

use App\Model\Facade\Auth\AuthorizationFacade;
use Nette\Application\UI\Presenter;

class MovieLastPresenter extends \App\Module\User\UserPresenter
{

	public function __construct(AuthorizationFacade $authorizationFacade)
	{
		parent::__construct($authorizationFacade);
	}

}
