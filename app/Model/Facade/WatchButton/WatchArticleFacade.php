<?php declare(strict_types = 1);

namespace App\Model\Facade\WatchButton;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Auth\LoginFunctions;
use Doctrine\ORM\EntityManagerInterface;


final class WatchArticleFacade
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
