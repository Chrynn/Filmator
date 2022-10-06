<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Movie\components\ButtonLike;

use App\Model\Database\Entity\MovieEntity;

interface ButtonLikeFactory
{

	public function create(MovieEntity $movie): ButtonLike;

}
