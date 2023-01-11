<?php declare(strict_types = 1);

namespace App\Module\Front\Serial\components\ButtonLater;

use App\Model\Database\Entity\SerialEntity;

interface ButtonLaterFactory
{

	public function create(SerialEntity $serial): ButtonLater;

}
