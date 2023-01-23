<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Like;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class ArticleLikeFacade extends AbstractFacade
{

	protected readonly UserEntity $user;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	) {
		parent::__construct($authorizationFacade, $entityManager);

		$this->user = $this->getLoggedUser();
	}


	public function markLike(ArticleEntity $article): void
	{
		$user = $this->user;

		if ($article->getLikeUser()->contains($user)) {
			return;
		}

		$article->getLikeUser()->add($user);
		$user->getLikeArticle()->add($article);

		$this->flush();
	}


	public function unmarkLike(ArticleEntity $article): void
	{
		$user = $this->user;

		if (!$article->getLikeUser()->contains($user)) {
			return;
		}

		$article->getLikeUser()->removeElement($user);
		$user->getLikeArticle()->removeElement($article);

		$this->flush();
	}


	public function isMarkedLike(ArticleEntity $article): bool
	{
		return $article->getLikeUser()->contains($this->user);
	}

}
