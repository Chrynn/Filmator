<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Like;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class SerialLikeFacade extends AbstractFacade
{

	protected readonly UserEntity $user;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	) {
		parent::__construct($authorizationFacade, $entityManager);

		$this->user = $this->getLoggedUser();
	}


	public function markLike(SerialEntity $serial): void
	{
		$user = $this->user;

		if ($serial->getLikeUser()->contains($user)) {
			return;
		}

		$serial->getLikeUser()->add($user);
		$user->getLikeSerial()->add($serial);

		$this->flush();
	}


	public function unmarkLike(SerialEntity $serial): void
	{
		$user = $this->user;

		if (!$serial->getLikeUser()->contains($user)) {
			return;
		}

		$serial->getLikeUser()->removeElement($user);
		$user->getLikeSerial()->removeElement($serial);

		$this->flush();
	}


	public function isMarkedLike(SerialEntity $serial): bool
	{
		return $serial->getLikeUser()->contains($this->user);
	}

}
