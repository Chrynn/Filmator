<?php

declare(strict_types=1);

namespace App\Model\Trait;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

trait hasCreatedAt
{

	#[ORM\Column(type: "datetime", nullable: false)]
	protected DateTime $createdAt;


	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

}