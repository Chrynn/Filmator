<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "token_permanent_login")]
final class PermanentLoginEntity
{

	#[Id]
	#[GeneratedValue(strategy: "AUTO")]
	#[Column(type: "integer")]
	protected int $id;

	#[Column(type: "string", nullable: false)]
	protected string $validator;

	#[Column(type: "smallint", nullable: false)]
	protected int $userId;

	#[Column(type: "datetime", nullable: false)]
	protected \DateTime $createdAt;

	#[Column(type: "datetime", nullable: false)]
	protected \DateTime $expiration;


	public function getId(): int
	{
		return $this->id;
	}


	public function getValidator(): string
	{
		return $this->validator;
	}


	public function setValidator(string $validator): void
	{
		$this->validator = $validator;
	}


	public function getUserId(): int
	{
		return $this->userId;
	}


	public function setUserId(int $userId): void
	{
		$this->userId = $userId;
	}


	public function setCreatedAt(\DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}


	public function getExpiration(): \DateTime
	{
		return $this->expiration;
	}


	public function setExpiration(\DateTime $expiration): void
	{
		$this->expiration = $expiration;
	}

}