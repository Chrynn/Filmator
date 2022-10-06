<?php declare(strict_types = 1);

namespace App\Model\Service\Serial;

use App\Model\Database\Entity\SerialEntity;
use Doctrine\ORM\EntityManagerInterface;

final class SerialService implements ISerialService
{

	public function __construct(
		private readonly EntityManagerInterface $entityManager
	) {}


	public function getSerials(): array
	{
		return $this->entityManager->getRepository(SerialEntity::class)->findAll();
	}


	public function getSerialBySlug(string $slug): SerialEntity
	{
		return $this->entityManager->getRepository(SerialEntity::class)->findOneBy([
			"slug" => $slug,
		]);
	}


	public function getSerialsByLimit(int $limit): array
	{
		return $this->entityManager->getRepository(SerialEntity::class)->findBy([], null, $limit, 0);
	}

}
