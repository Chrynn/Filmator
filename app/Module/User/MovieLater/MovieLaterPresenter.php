<?php declare(strict_types=1);

namespace App\Module\User\MovieLater;

use App\Model\Facade\Auth\AuthorizationFacade;
use Nette\Application\UI\Presenter;

class MovieLaterPresenter extends \App\Module\User\UserPresenter
{

	public function __construct(AuthorizationFacade $authorizationFacade)
	{
		parent::__construct($authorizationFacade);
	}

}
