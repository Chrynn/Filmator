<?php declare(strict_types = 1);

namespace App\Model\Service\Actor;

use App\Model\Database\Entity\ActorEntity;
use Doctrine\ORM\EntityManagerInterface;

final class ActorService
{

	private EntityManagerInterface $entityManager;


	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	public function getActors(): array
	{
		return $this->entityManager->getRepository(ActorEntity::class)->findAll();
	}


	public function getActorBySlug(string $slug): ActorEntity
	{
		return $this->entityManager->getRepository(ActorEntity::class)->findOneBy([
			"slug" => $slug,
		]);
	}

}
