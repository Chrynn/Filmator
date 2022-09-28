<?php declare(strict_types = 1);

namespace App\Model\Service;

use App\Model\Database\Entity\TokenEntity;
use Doctrine\ORM\EntityManagerInterface;

final class TokenService
{

	private EntityManagerInterface $entityManager;


	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	public function add(int $userID, string $email): array
	{
		$randomSeparator = '!~!';
		$validator = "logged" . $randomSeparator . $email;
		$validatorHash = hash("sha256", $validator);
		$timeNow = new \DateTime('now');
		$expiration = $timeNow->modify("+30 day");

		$tokenLogged = new TokenEntity();
		$tokenLogged->setValidator($validatorHash);
		$tokenLogged->setUserID($userID);
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

}
