<?php declare(strict_types=1);

namespace App\Module\User\ArticleLast;

use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Service\Article\ArticleService;
use App\Module\User\UserPresenter;

class ArticleLastPresenter extends UserPresenter
{

	public function __construct(
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		private readonly ArticleService $articleService
	) {
		parent::__construct(
			$permanentLoginFacade,
			$authorizationFacade
		);
	}


	public function actionDefault(): void
	{
		$loggedUser = $this->getLoggedUser();

		$this->getTemplate()->articles = $this->articleService->getArticlesLastByUser($loggedUser);
	}

}
