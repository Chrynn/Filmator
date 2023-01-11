<?php declare(strict_types=1);

namespace App\Module\User\SerialLast;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Module\User\UserPresenter;
use Doctrine\ORM\EntityManagerInterface;

class SerialLastPresenter extends UserPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager
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
		$this->getTemplate()->serials = $this->entityManager->createQueryBuilder()
			->select("serial")
			->from(SerialEntity::class, "serial")
			->getQuery()
			->getResult();
	}

}
