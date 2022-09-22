<?php declare(strict_types=1);

namespace App\Module\Ghost\Article;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Path\PathFacade;
use App\Model\Service\Query\ArticleEntityQuery;
use App\Module\Ghost\_component\Forgotten\ForgottenFactory;
use App\Module\Ghost\_component\Login\LoginFactory;
use App\Module\Ghost\_component\Register\RegisterFactory;
use App\Module\Ghost\Article\Component\LikeButton\LikeButton;
use App\Module\Ghost\Article\Component\LikeButton\LikeButtonFactory;
use App\Module\Ghost\Article\Component\WatchButton\WatchButton;
use App\Module\Ghost\Article\Component\WatchButton\WatchButtonFactory;
use App\Module\Ghost\GhostPresenter;

class ArticlePresenter extends GhostPresenter
{

	private ArticleEntityQuery $articleEntityQuery;
	private LikeButtonFactory $likeButtonFactory;
	private WatchButtonFactory $watchButtonFactory;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		LoginFactory $loginFactory,
		RegisterFactory $registerFactory,
		ArticleEntityQuery $articleEntityQuery,
		LikeButtonFactory $likeButtonFactory,
		WatchButtonFactory $watchButtonFactory,
		ForgottenFactory $forgottenFactory,
		PathFacade $pathFacade
	)
    {
        parent::__construct($authorizationFacade, $loginFactory, $registerFactory, $forgottenFactory, $pathFacade);
		$this->articleEntityQuery = $articleEntityQuery;
		$this->likeButtonFactory = $likeButtonFactory;
		$this->watchButtonFactory = $watchButtonFactory;
	}

	protected function actionDefault(): void
	{
		$this->getTemplate()->articles = $this->articleEntityQuery->getArticles();
	}

    public function actionDetail(string $url): void
    {
        $this->getTemplate()->article = $this->articleEntityQuery->getArticleBySlug($url);
		$this->getTemplate()->nextArticles = $this->articleEntityQuery->getArticlesByLimit(3);
    }

    protected function createComponentLikeButton(): LikeButton
    {
    	$url = $this->getParameter("url");
        $article = $this->articleEntityQuery->getArticleBySlug($url);

        $component = $this->likeButtonFactory->create($article);
        $component->onLike[] = function(): void{
            $this->flashMessage("Líbí se", "success");
            $this->redirect("this");
        };
        $component->onDislike[] = function(): void{
            $this->flashMessage("Nelíbí se", "success");
            $this->redirect("this");
        };
        return $component;
    }

	protected function createComponentWatchButton(): WatchButton
	{
		$url = $this->getParameter("url");
		$article = $this->articleEntityQuery->getArticleBySlug($url);

		$component = $this->watchButtonFactory->create($article);
		$component->onWatch[] = function (): void {
			$this->flashMessage("Přidáno", "success");
			$this->redirect("this");
		};
		$component->onUnWatch[] = function (): void {
			$this->flashMessage("Odebráno", "success");
			$this->redirect("this");
		};
		return $component;
	}

}

