<?php declare(strict_types = 1);

namespace App\Model\Service\Serial;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Database\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Security\User;

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

	public function getSerialsLastByUser(UserEntity $user): array
	{
		return $this->entityManager->createQueryBuilder()
			->select("serial, serialLast, user")
			->from(SerialEntity::class, "serial")
			->join("serial.serialLast", "serialLast")
			->join("serialLast.user", "user")
			->where("user.id = :userId")
			->setParameter("userId", $user->getId())
			->orderBy("serialLast.createdAt", "DESC")
			->getQuery()
			->getResult();
	}

}
