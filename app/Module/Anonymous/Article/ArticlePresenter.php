<?php declare(strict_types=1);

namespace App\Module\Anonymous\Article;

use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Article\ArticleService;
use App\Module\Anonymous\AnonymousPresenter;
use App\Module\Anonymous\Article\components\ButtonLater\ButtonLater;
use App\Module\Anonymous\Article\components\ButtonLater\ButtonLaterFactory;
use App\Module\Anonymous\Article\components\ButtonLike\ButtonLike;
use App\Module\Anonymous\Article\components\ButtonLike\ButtonLikeFactory;
use App\Module\Anonymous\components\Forgotten\ForgottenFactory;
use App\Module\Anonymous\components\Login\LoginFactory;
use App\Module\Anonymous\components\Register\RegisterFactory;

class ArticlePresenter extends AnonymousPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		RegisterFactory $registerFactory,
		LoginFactory $loginFactory,
		ForgottenFactory $forgottenFactory,
		private readonly ArticleService $articleService,
		private readonly ButtonLikeFactory $buttonLikeFactory,
		private readonly ButtonLaterFactory $buttonLaterFactory
	)
    {
        parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade,
			$registerFactory,
			$loginFactory,
			$forgottenFactory
		);
	}


	protected function actionDefault(): void
	{
		$this->getTemplate()->articles = $this->articleService->getArticles();
	}


    public function actionDetail(string $url): void
    {
        $this->getTemplate()->article = $this->articleService->getArticleBySlug($url);
		$this->getTemplate()->nextArticles = $this->articleService->getArticlesByLimit(3);
    }


    protected function createComponentButtonLike(): ButtonLike
    {
    	$url = $this->getParameter("url");
        $article = $this->articleService->getArticleBySlug($url);

        $component = $this->buttonLikeFactory->create($article);
        $component->onLike[] = function(): void{
            $this->flashMessage("L??b?? se", "success");
            $this->redirect("this");
        };
        $component->onDislike[] = function(): void{
            $this->flashMessage("Nel??b?? se", "success");
            $this->redirect("this");
        };
        return $component;
    }


	protected function createComponentWatchButton(): ButtonLater
	{
		$url = $this->getParameter("url");
		$article = $this->articleService->getArticleBySlug($url);

		$component = $this->buttonLaterFactory->create($article);
		$component->onWatch[] = function (): void {
			$this->flashMessage("P??id??no", "success");
			$this->redirect("this");
		};
		$component->onUnWatch[] = function (): void {
			$this->flashMessage("Odebr??no", "success");
			$this->redirect("this");
		};
		return $component;
	}

}
