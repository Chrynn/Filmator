<?php declare(strict_types = 1);

namespace App\Module\Front\Serial\components\ButtonLike;

use App\Model\Database\Entity\SerialEntity;

interface ButtonLikeFactory
{

	public function create(SerialEntity $serial): ButtonLike;

}
