<?php declare(strict_types = 1);

namespace App\Model\Facade\User\ButtonLater;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LaterSerialFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function later(SerialEntity $serial): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($serial->getLaterUser()->contains($user)) {
			return;
		}

		$serial->getLaterUser()->add($user);
		$user->getLaterSerial()->add($serial);

		$this->entityManager->flush();
	}


	public function unLater(SerialEntity $serial): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$serial->getLaterUser()->contains($user)) {
			return;
		}

		$serial->getLaterUser()->removeElement($user);
		$user->getLaterSerial()->removeElement($serial);

		$this->entityManager->flush();
	}


	public function laterMarked(SerialEntity $serial): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();
		return $serial->getLaterUser()->contains($user);
	}

}
