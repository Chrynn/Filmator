<?php declare(strict_types = 1);

namespace App\Model\Service\Query;

use App\Model\Database\Entity\SerialEntity;
use Doctrine\ORM\EntityManagerInterface;


final class SerialEntityQuery
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

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
