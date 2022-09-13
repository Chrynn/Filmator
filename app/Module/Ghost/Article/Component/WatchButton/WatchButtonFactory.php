<?php declare(strict_types = 1);

namespace App\Module\Ghost\Article\Component\WatchButton;

use App\Model\Database\Entity\ArticleEntity;

interface WatchButtonFactory
{

	public function create(ArticleEntity $article): WatchButton;

}
