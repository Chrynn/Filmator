<?php declare(strict_types = 1);

namespace App\Model\Service\Article;

use App\Model\Database\Entity\ArticleEntity;

interface IArticleService
{

	public function getArticles(): array;

	public function getArticleBySlug(string $slug): ArticleEntity;

	public function getArticlesByLimit(int $limit): array;

}
