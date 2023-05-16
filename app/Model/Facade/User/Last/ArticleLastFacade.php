<?php declare(strict_types = 1);

namespace App\Model\Facade\User\Last;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Database\Entity\ArticleLastEntity;
use App\Model\Facade\AbstractFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use Doctrine\ORM\EntityManagerInterface;

final class ArticleLastFacade extends AbstractFacade
{

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		EntityManagerInterface $entityManager,
	) {
		parent::__construct($authorizationFacade, $entityManager);
	}


	public function markLast(ArticleEntity $article): void
	{
		$user = $this->getLoggedUser();

		$articleVisitedEntity = new ArticleLastEntity();
		$articleVisitedEntity->setArticle($article);
		$articleVisitedEntity->setUser($user);

		$this->saveEntity($articleVisitedEntity);
	}

}