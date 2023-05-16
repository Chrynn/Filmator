<?php

declare(strict_types=1);

namespace App\Model\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractService
{

	public function __construct(
		protected EntityManagerInterface $entityManager
	) {
	}


	protected function saveEntity(object $entity): void
	{
		$this->entityManager->persist($entity);
		$this->entityManager->flush();
	}
	
}