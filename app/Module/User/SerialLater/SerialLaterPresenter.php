<?php declare(strict_types=1);

namespace App\Module\User\SerialLater;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\User\UserPresenter;
use Doctrine\ORM\EntityManagerInterface;

class SerialLaterPresenter extends UserPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		public readonly AuthorizationFacade $authorizationFacade,
		public readonly EntityManagerInterface $entityManager
	)
	{
		parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade
		);
	}

	public function actionDefault(): void
	{
		$laterSerials = $this->authorizationFacade->getLoggedUser()->getLaterSerial();
		$this->getTemplate()->serials = $laterSerials->isEmpty() ? [] : $laterSerials;
	}

}
