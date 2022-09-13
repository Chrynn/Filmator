<?php declare(strict_types = 1);

namespace App\Module\Ghost\Movie\Component\WatchButton;

use App\Model\Database\Entity\MovieEntity;

interface WatchButtonFactory
{

	public function create(MovieEntity $movie): WatchButton;

}
