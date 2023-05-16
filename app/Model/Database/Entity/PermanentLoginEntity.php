<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use App\Model\Trait\hasCreatedAt;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "token_permanent_login")]
class PermanentLoginEntity extends AbstractListEntity
{

	use hasCreatedAt;


	#[ORM\Column(type: "string", nullable: false)]
	protected string $validator;

	#[ORM\Column(type: "smallint", nullable: false)]
	protected int $userId;

	#[ORM\Column(type: "datetime", nullable: false)]
	protected DateTime $expiration;


	public function __construct()
	{
		$this->createdAt = new DateTime();
	}


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


	public function setCreatedAt(DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}


	public function getExpiration(): DateTime
	{
		return $this->expiration;
	}


	public function setExpiration(DateTime $expiration): void
	{
		$this->expiration = $expiration;
	}

}