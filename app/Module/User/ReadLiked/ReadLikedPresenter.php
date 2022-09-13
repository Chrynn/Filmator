<?php declare(strict_types=1);

namespace App\Module\User\ReadLiked;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Auth\LoginFunctions;
use Nette\Application\UI\Presenter;

class ReadLikedPresenter extends \App\Module\User\UserPresenter
{

	public function __construct(AuthorizationFacade $authorizationFacade)
	{
		parent::__construct($authorizationFacade);
	}

}
