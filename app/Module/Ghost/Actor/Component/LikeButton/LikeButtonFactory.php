<?php declare(strict_types = 1);

namespace App\Module\Ghost\Actor\Component\LikeButton;

use App\Model\Database\Entity\ActorEntity;

interface LikeButtonFactory
{

	public function create(ActorEntity $actor): LikeButton;

}
