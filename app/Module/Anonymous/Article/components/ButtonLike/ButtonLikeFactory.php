<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Article\components\ButtonLike;

use App\Model\Database\Entity\ArticleEntity;

interface ButtonLikeFactory
{

	public function create(ArticleEntity $article): ButtonLike;

}
