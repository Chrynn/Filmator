<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Later;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LaterSerialFacade extends AbstractFacade
{

	protected readonly UserEntity $user;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	) {
		parent::__construct($authorizationFacade, $entityManager);
		$this->user = $this->getLoggedUser();
	}


	public function markLater(SerialEntity $serial): void
	{
		$user = $this->user;

		if ($serial->getLaterUser()->contains($user)) {
			return;
		}

		$serial->getLaterUser()->add($user);
		$user->getLaterSerial()->add($serial);

		$this->flush();
	}


	public function unmarkLater(SerialEntity $serial): void
	{
		$user = $this->user;

		if (!$serial->getLaterUser()->contains($user)) {
			return;
		}

		$serial->getLaterUser()->removeElement($user);
		$user->getLaterSerial()->removeElement($serial);

		$this->flush();
	}


	public function isMarkedLater(SerialEntity $serial): bool
	{
		return $serial->getLaterUser()->contains($this->user);
	}

}
