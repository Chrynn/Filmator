<?php declare(strict_types = 1);

namespace App\Model\Service\Actor;

use App\Model\Database\Entity\ActorEntity;

interface IActorService
{

	public function getActors(): array;

	public function getActorBySlug(string $slug): ActorEntity;

}
