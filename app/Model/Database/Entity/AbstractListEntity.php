<?php

declare(strict_types=1);

namespace App\Model\Database\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractListEntity
{

	#[ORM\Id]
	#[ORM\GeneratedValue(strategy: "AUTO")]
	#[ORM\Column(type: "integer", nullable: false)]
	protected int $id;


	public function getId(): int
	{
		return $this->id;
	}

}