<?php declare(strict_types = 1);

namespace App\Module\Ghost\Article\Component\LikeButton;

use App\Model\Database\Entity\ArticleEntity;

interface LikeButtonFactory
{

	public function create(ArticleEntity $article): LikeButton;

}
