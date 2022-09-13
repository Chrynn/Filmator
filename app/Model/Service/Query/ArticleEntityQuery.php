<?php declare(strict_types = 1);

namespace App\Model\Service\Query;


use App\Model\Database\Entity\ArticleEntity;
use Doctrine\ORM\EntityManagerInterface;

class ArticleEntityQuery
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

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

}
