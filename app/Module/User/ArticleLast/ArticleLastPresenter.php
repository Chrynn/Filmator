<?php declare(strict_types=1);

namespace App\Module\User\ArticleLast;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Module\User\UserPresenter;
use Doctrine\ORM\EntityManagerInterface;

class ArticleLastPresenter extends UserPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		private readonly AuthorizationFacade $authorizationFacade,
		private readonly EntityManagerInterface $entityManager
	)
	{
		parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade
		);
	}


	public function actionDefault(): void
	{
		$loggedUser = $this->authorizationFacade->getLoggedUser();
		$this->getTemplate()->articles = $this->entityManager->createQueryBuilder()
			->select("article")
			->from(ArticleEntity::class, "article")
			->getQuery()
			->getResult();
		/*
		$test = $this->entityManager->createQueryBuilder()
			->select("article, articleVisited")
			->from(ArticleEntity::class, "article")
			->join("articleVisited.article", "articleVisitedArticle")
			->where("articleVisited.user = :loggedUser")
			->setParameter("loggedUser", $loggedUser)
			->getQuery()
			->getResult();
		$this->getTemplate()->articles = $test;
		bdump($test);
		*/
	}

}
