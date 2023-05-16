<?php declare(strict_types = 1);

namespace App\Model\Service\Article;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Database\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;

final class ArticleService implements IArticleService
{

	public function __construct(
		private readonly EntityManagerInterface $entityManager
	) {}


	public function getArticles(): array
	{
		return $this->entityManager->getRepository(ArticleEntity::class)->findAll();
	}


	public function getArticleBySlug(string $slug): ArticleEntity
	{
		return $article = $this->entityManager->getRepository(ArticleEntity::class)->findOneBy([
			"slug" => $slug,
		]);
	}


	public function getArticlesByLimit(int $limit): array
	{
		return $this->entityManager->getRepository(ArticleEntity::class)->findBy([], null, $limit, 0);
	}


	public function getArticlesLastByUser(UserEntity $user): array
	{
		return $this->entityManager->createQueryBuilder()
			->select("article, articleLast, user")
			->from(ArticleEntity::class, "article")
			->join("article.articleLast", "articleLast")
			->join("articleLast.user", "user")
			->where("user.id = :userId")
			->setParameter("userId", $user->getId())
			->orderBy("articleLast.createdAt", "DESC")
			->getQuery()
			->getResult();
	}

}
