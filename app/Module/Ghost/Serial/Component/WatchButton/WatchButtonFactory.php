<?php declare(strict_types = 1);

namespace App\Module\Ghost\Serial\Component\WatchButton;

use App\Model\Database\Entity\SerialEntity;

interface WatchButtonFactory
{

	public function create(SerialEntity $serial): WatchButton;

}
