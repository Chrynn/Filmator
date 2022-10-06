<?php declare(strict_types = 1);

namespace App\Model\Service\Actor;

use App\Model\Database\Entity\ActorEntity;
use Doctrine\ORM\EntityManagerInterface;

final class ActorService implements IActorService
{

	public function __construct(
		private readonly EntityManagerInterface $entityManager
	) {}


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
