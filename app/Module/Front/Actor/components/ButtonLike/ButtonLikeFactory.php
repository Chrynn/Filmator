<?php declare(strict_types = 1);

namespace App\Module\Front\Actor\components\ButtonLike;

use App\Model\Database\Entity\ActorEntity;

interface ButtonLikeFactory
{

	public function create(ActorEntity $actor): ButtonLike;

}
