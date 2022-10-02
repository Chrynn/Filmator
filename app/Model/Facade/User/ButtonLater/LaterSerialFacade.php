<?php declare(strict_types = 1);

namespace App\Model\Facade\User\ButtonLater;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LaterSerialFacade
{

	private AuthorizationFacade $authorizationFacade;
	private EntityManagerInterface $entityManager;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	)
	{
		$this->authorizationFacade = $authorizationFacade;
		$this->entityManager = $entityManager;
	}


	public function watch(SerialEntity $serial): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($serial->getWatchUser()->contains($user)) {

			return;
		}

		$serial->getWatchUser()->add($user);
		$user->getWatchSerial()->add($serial);

		$this->entityManager->flush();
	}


	public function unWatch(SerialEntity $serial): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$serial->getWatchUser()->contains($user)) {

			return;
		}

		$serial->getWatchUser()->removeElement($user);
		$user->getWatchSerial()->removeElement($serial);

		$this->entityManager->flush();
	}


	public function wantWatch(SerialEntity $serial): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();

		return $serial->getWatchUser()->contains($user);
	}

}
