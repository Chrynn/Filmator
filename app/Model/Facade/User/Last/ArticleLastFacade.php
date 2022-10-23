<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Last;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Database\Entity\ArticleLastEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class ArticleLastFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function markLast(ArticleEntity $article): void
	{
		$user = $this->authorizationFacade->getLoggedUser();
		$articleVisitedEntity = new ArticleLastEntity();
		$articleVisitedEntity->setArticle($article);
		$articleVisitedEntity->setUser($user);

		$this->entityManager->persist($articleVisitedEntity);
		$this->entityManager->flush();
	}

}