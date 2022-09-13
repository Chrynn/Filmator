<?php declare(strict_types = 1);

namespace App\Module\Ghost\Serial\Component\LikeButton;

use App\Model\Database\Entity\SerialEntity;

interface LikeButtonFactory
{

	public function create(SerialEntity $serial): LikeButton;

}
