<?php declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Trait\hasCreatedAt;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "serial_last")]
class SerialLastEntity extends AbstractListEntity
{

	use hasCreatedAt;


	#[ORM\ManyToOne(targetEntity: UserEntity::class, inversedBy: "userSerialLast")]
	protected UserEntity $user;

	#[ORM\ManyToOne(targetEntity: SerialEntity::class, inversedBy: "serialLast")]
	protected SerialEntity $serial;


	public function __construct()
	{
		$this->createdAt = new DateTime();
	}


	public function getUser(): UserEntity
	{
		return $this->user;
	}

	public function setUser(UserEntity $user): void
	{
		$this->user = $user;
	}

	public function getSerial(): SerialEntity
	{
		return $this->serial;
	}

	public function setSerial(SerialEntity $serial): void
	{
		$this->serial = $serial;
	}

}