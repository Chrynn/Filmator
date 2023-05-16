<?php

declare(strict_types=1);

namespace App\Model\Facade;

use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager
	)
	{
	}

	protected function getLoggedUser(): UserEntity
	{
		return $this->authorizationFacade->getLoggedUser();
	}

	protected function saveEntity(object $entity): void
	{
		$this->entityManager->persist($entity);
		$this->entityManager->flush();
	}

	protected function flush(): void
	{
		$this->entityManager->flush();
	}

}