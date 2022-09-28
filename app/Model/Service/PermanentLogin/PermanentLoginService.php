<?php declare(strict_types = 1);

namespace App\Model\Service\PermanentLogin;

use App\Model\Database\Entity\PermanentLoginEntity;
use App\Model\Service\User\UserService;
use Doctrine\ORM\EntityManagerInterface;

final class PermanentLoginService
{

	private EntityManagerInterface $entityManager;
	private UserService $userService;


	public function __construct(
		EntityManagerInterface $entityManager,
		UserService $userService
	)
	{
		$this->entityManager = $entityManager;
		$this->userService = $userService;
	}


	public function add(string $email): array
	{
		$user = $this->userService->getUserByEmail($email);
		$userId = $user->getId();

		$randomSeparator = '!~!';
		$validator = "logged" . $randomSeparator . $email;
		$validatorHash = hash("sha256", $validator);
		$timeNow = new \DateTime('now');
		$expiration = (clone $timeNow)->modify("+30 day");

		$tokenLogged = new PermanentLoginEntity();
		$tokenLogged->setValidator($validatorHash);
		$tokenLogged->setUserID($userId);
		$tokenLogged->setCreatedAt($timeNow);
		$tokenLogged->setExpiration($expiration);
		$this->entityManager->persist($tokenLogged);
		$this->entityManager->flush();

		$tokenID = $tokenLogged->getId();

		return [
			"id" => $tokenID,
			"hash" => $validatorHash
		];
	}


	public function delete(int $id): void
	{
		$tokenEntity = $this->entityManager->getRepository(PermanentLoginEntity::class)->find($id);
		if ($tokenEntity) {
			$this->entityManager->remove($tokenEntity);
			$this->entityManager->flush();
		}
	}


	public function getTokenById(string $tokenId): ?PermanentLoginEntity
	{
		return $this->entityManager->getRepository(PermanentLoginEntity::class)->findOneBy([
			"id" => $tokenId,
		]);
	}

}
