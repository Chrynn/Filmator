<?php declare(strict_types=1);

namespace App\Model\Facade\User\Last;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Database\Entity\SerialLastEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class SerialLastFacade extends AbstractFacade
{

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager
	) {
		parent::__construct($authorizationFacade, $entityManager);
	}


	public function markLast(SerialEntity $serial): void
	{
		$user = $this->getLoggedUser();

		$articleVisitedEntity = new SerialLastEntity();
		$articleVisitedEntity->setSerial($serial);
		$articleVisitedEntity->setUser($user);

		$this->saveEntity($articleVisitedEntity);
	}

}