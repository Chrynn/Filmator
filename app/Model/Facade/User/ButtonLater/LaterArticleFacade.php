<?php declare(strict_types = 1);

namespace App\Model\Facade\User\ButtonLater;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LaterArticleFacade
{

	public function __construct(
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager,
	) {}


	public function watch(ArticleEntity $article): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if ($article->getWatchUser()->contains($user)) {
			return;
		}

		$article->getWatchUser()->add($user);
		$user->getWatchArticle()->add($article);

		$this->entityManager->flush();
	}


	public function unWatch(ArticleEntity $article): void
	{
		$user = $this->authorizationFacade->getLoggedUser();

		if (!$article->getWatchUser()->contains($user)) {
			return;
		}

		$article->getWatchUser()->removeElement($user);
		$user->getWatchArticle()->removeElement($article);

		$this->entityManager->flush();
	}


	public function wantWatch(ArticleEntity $article): bool
	{
		$user = $this->authorizationFacade->getLoggedUser();
		return $article->getWatchUser()->contains($user);
	}

}
