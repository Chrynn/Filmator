<?php declare(strict_types=1);

namespace App\Model\Database\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="serial_last")
 */
class SerialLastEntity
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected int $id;

	/**
	 * @ORM\ManyToOne(targetEntity="UserEntity", inversedBy="userSerialLast")
	 */
	protected UserEntity $user;

	/**
	 * @ORM\ManyToOne(targetEntity="SerialEntity", inversedBy="serialLast")
	 */
	protected SerialEntity $serial;

	/**
	 * @ORM\Column(type="datetime", nullable=false)
	 */
	protected DateTime $createdAt;


	public function __construct()
	{
		$this->createdAt = new DateTime();
	}

	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
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