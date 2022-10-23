<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Like;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class ArticleLikeFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function like(ArticleEntity $article): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($article->getLikeUser()->contains($user)) {
			return;
		}

		$article->getLikeUser()->add($user);
		$user->getLikeArticle()->add($article);

		$this->entityManager->flush();
	}


	public function unLike(ArticleEntity $article): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$article->getLikeUser()->contains($user)) {
			return;
		}

		$article->getLikeUser()->removeElement($user);
		$user->getLikeArticle()->removeElement($article);

		$this->entityManager->flush();
	}


	public function isLiked(ArticleEntity $article): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();

		return $article->getLikeUser()->contains($user);
	}

}
