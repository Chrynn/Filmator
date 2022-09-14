<?php declare(strict_types = 1);

namespace App\Module\Ghost\Movie;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Path\PathFacade;
use App\Model\Service\Query\MovieEntityQuery;
use App\Module\Ghost\_component\Forgotten\ForgottenFactory;
use App\Module\Ghost\_component\Login\LoginFactory;
use App\Module\Ghost\_component\Register\RegisterFactory;
use App\Module\Ghost\GhostPresenter;
use App\Module\Ghost\Movie\Component\LikeButton\LikeButton;
use App\Module\Ghost\Movie\Component\LikeButton\LikeButtonFactory;
use App\Module\Ghost\Movie\Component\WatchButton\WatchButton;
use App\Module\Ghost\Movie\Component\WatchButton\WatchButtonFactory;


class MoviePresenter extends GhostPresenter
{

	private MovieEntityQuery $movieEntityQuery;
	private LikeButtonFactory $likeButtonFactory;
	private WatchButtonFactory $watchButtonFactory;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		LoginFactory $loginFactory,
		RegisterFactory $registerFactory,
		MovieEntityQuery $movieEntityQuery,
		LikeButtonFactory $likeButtonFactory,
		WatchButtonFactory $watchButtonFactory,
		PathFacade $pathFacade,
		ForgottenFactory $forgottenFactory
  	)
  	{
		parent::__construct($authorizationFacade, $loginFactory, $registerFactory, $forgottenFactory, $pathFacade);
		$this->movieEntityQuery = $movieEntityQuery;
		$this->likeButtonFactory = $likeButtonFactory;
		$this->watchButtonFactory = $watchButtonFactory;
	}

	public function actionDefault(): void
	{
		$this->getTemplate()->movies = $this->movieEntityQuery->getMovies();
	}

	public function actionDetail(string $url): void
	{
		$this->getTemplate()->movie = $this->movieEntityQuery->getMovieBySlug($url);
		$this->getTemplate()->nextMovies = $this->movieEntityQuery->getMoviesByLimit(4);
	}

	protected function createComponentLikeButton(): LikeButton
	{
		$url = $this->getParameter("url");
		$movie = $this->movieEntityQuery->getMovieBySlug($url);

		$component = $this->likeButtonFactory->create($movie);
		$component->onLike[] = function (): void {
			$this->flashMessage("Líbí se", "success");
			$this->redirect("this");
		};
		$component->onDislike[] = function (): void {
			$this->flashMessage("Nelíbí se", "success");
			$this->redirect("this");
		};
		return $component;
	}

	protected function createComponentWatchButton(): WatchButton
	{
		$url = $this->getParameter("url");
		$movie = $this->movieEntityQuery->getMovieBySlug($url);

		$component = $this->watchButtonFactory->create($movie);
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

