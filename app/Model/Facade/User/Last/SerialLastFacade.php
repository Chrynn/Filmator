<?php declare(strict_types=1);

namespace App\Model\Facade\User\Last;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Database\Entity\SerialLastEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class SerialLastFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function markLast(SerialEntity $serial): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		$articleVisitedEntity = new SerialLastEntity();
		$articleVisitedEntity->setSerial($serial);
		$articleVisitedEntity->setUser($user);

		$this->entityManager->persist($articleVisitedEntity);
		$this->entityManager->flush();
	}

}