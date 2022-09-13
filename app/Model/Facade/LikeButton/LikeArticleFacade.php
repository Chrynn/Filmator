<?php declare(strict_types = 1);

namespace App\Model\Facade\LikeButton;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Auth\LoginFunctions;
use Doctrine\ORM\EntityManagerInterface;


final class LikeArticleFacade
{

	private AuthorizationFacade $authorizationFacade;
	private EntityManagerInterface $entityManager;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	)
	{
		$this->authorizationFacade = $authorizationFacade;
		$this->entityManager = $entityManager;
	}

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

	public function dislike(ArticleEntity $article): void
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
