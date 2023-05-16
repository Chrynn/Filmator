<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Later;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class LaterArticleFacade extends AbstractFacade
{

	protected readonly UserEntity $user;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	) {
		parent::__construct($authorizationFacade, $entityManager);

		$this->user = $this->getLoggedUser();
	}


	public function markLater(ArticleEntity $article): void
	{
		$user = $this->user;

		if ($article->getLaterUser()->contains($user)) {
			return;
		}

		$article->getLaterUser()->add($user);
		$user->getLaterArticle()->add($article);

		$this->flush();
	}


	public function unmarkLater(ArticleEntity $article): void
	{
		$user = $this->user;

		if (!$article->getLaterUser()->contains($user)) {
			return;
		}

		$article->getLaterUser()->removeElement($user);
		$user->getLaterArticle()->removeElement($article);

		$this->flush();
	}


	public function isMarkedLater(ArticleEntity $article): bool
	{
		return $article->getLaterUser()->contains($this->user);
	}

}
