<?php declare(strict_types = 1);

namespace App\Module\Front\Movie\components\ButtonLater;

use App\Model\Database\Entity\MovieEntity;

interface ButtonLaterFactory
{

	public function create(MovieEntity $movie): ButtonLater;

}
