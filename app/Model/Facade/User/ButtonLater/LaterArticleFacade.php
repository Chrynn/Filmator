<?php declare(strict_types = 1);

namespace App\Model\Facade\User\ButtonLater;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LaterArticleFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function later(ArticleEntity $article): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($article->getLaterUser()->contains($user)) {
			return;
		}

		$article->getLaterUser()->add($user);
		$user->getLaterArticle()->add($article);

		$this->entityManager->flush();
	}


	public function unLater(ArticleEntity $article): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$article->getLaterUser()->contains($user)) {
			return;
		}

		$article->getLaterUser()->removeElement($user);
		$user->getLaterArticle()->removeElement($article);

		$this->entityManager->flush();
	}


	public function laterMarked(ArticleEntity $article): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();
		return $article->getLaterUser()->contains($user);
	}

}
