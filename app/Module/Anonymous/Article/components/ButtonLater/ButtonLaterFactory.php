<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Article\components\ButtonLater;

use App\Model\Database\Entity\ArticleEntity;

interface ButtonLaterFactory
{

	public function create(ArticleEntity $article): ButtonLater;

}
