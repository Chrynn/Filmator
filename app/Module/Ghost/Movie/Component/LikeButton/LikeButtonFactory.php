<?php declare(strict_types = 1);

namespace App\Module\Ghost\Movie\Component\LikeButton;

use App\Model\Database\Entity\MovieEntity;

interface LikeButtonFactory
{

	public function create(MovieEntity $movie): LikeButton;

}
