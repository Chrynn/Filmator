<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Actor\components\ButtonLike;

use App\Model\Database\Entity\ActorEntity;

interface ButtonLikeFactory
{

	public function create(ActorEntity $actor): ButtonLike;

}
