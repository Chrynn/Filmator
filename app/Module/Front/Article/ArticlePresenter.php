<?php declare(strict_types=1);

namespace App\Module\Front\Article;

use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\User\Last\ArticleLastFacade;
use App\Model\FlashMessage;
use App\Model\Service\Article\ArticleService;
use App\Module\Front\Article\components\ButtonLater\ButtonLater;
use App\Module\Front\Article\components\ButtonLater\ButtonLaterFactory;
use App\Module\Front\Article\components\ButtonLike\ButtonLike;
use App\Module\Front\Article\components\ButtonLike\ButtonLikeFactory;
use App\Module\Front\components\Forgotten\ForgottenFactory;
use App\Module\Front\components\Login\LoginFactory;
use App\Module\Front\components\Register\RegisterFactory;
use App\Module\Front\FrontPresenter;

class ArticlePresenter extends FrontPresenter
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
		private readonly ButtonLaterFactory $buttonLaterFactory,
		private readonly ArticleLastFacade $articleLastFacade
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
		$article = $this->articleService->getArticleBySlug($url);
		if ($this->userLogged()) {
			$this->articleLastFacade->markLast($article);
		}
        $this->getTemplate()->article = $article;
		$this->getTemplate()->nextArticles = $this->articleService->getArticlesByLimit(3);
    }


    protected function createComponentButtonLike(): ButtonLike
    {
    	$url = $this->getParameter("url");
        $article = $this->articleService->getArticleBySlug($url);

        $component = $this->buttonLikeFactory->create($article);
        $component->onLike[] = function(): void{
            $this->flashMessage("Líbí se", FlashMessage::TYPE_BASIC);
            $this->redirectThis();
        };
        $component->onDislike[] = function(): void{
            $this->flashMessage("Nelíbí se", FlashMessage::TYPE_BASIC);
            $this->redirectThis();
        };
        return $component;
    }


	protected function createComponentButtonLater(): ButtonLater
	{
		$url = $this->getParameter("url");
		$article = $this->articleService->getArticleBySlug($url);

		$component = $this->buttonLaterFactory->create($article);
		$component->onLater[] = function (): void {
			$this->flashBasic("Přidáno");
			$this->redirectThis();
		};
		$component->onUnLater[] = function (): void {
			$this->flashBasic("Odebráno");
			$this->redirectThis();
		};
		return $component;
	}

}
