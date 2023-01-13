<?php declare(strict_types = 1);

namespace App\Module\Front\Movie;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Facade\User\Last\MovieLastFacade;
use App\Model\FlashMessage;
use App\Model\Service\Movie\MovieService;
use App\Module\Front\components\Forgotten\ForgottenFactory;
use App\Module\Front\components\Login\LoginFactory;
use App\Module\Front\components\Register\RegisterFactory;
use App\Module\Front\FrontPresenter;
use App\Module\Front\Movie\components\ButtonLater\ButtonLater;
use App\Module\Front\Movie\components\ButtonLater\ButtonLaterFactory;
use App\Module\Front\Movie\components\ButtonLike\ButtonLike;
use App\Module\Front\Movie\components\ButtonLike\ButtonLikeFactory;

class MoviePresenter extends FrontPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		RegisterFactory $registerFactory,
		LoginFactory $loginFactory,
		ForgottenFactory $forgottenFactory,
		private readonly MovieService $movieService,
		private readonly ButtonLaterFactory $buttonLaterFactory,
		private readonly ButtonLikeFactory $buttonLikeFactory,
		private readonly MovieLastFacade $movieLastFacade
	) {
		parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade,
			$registerFactory,
			$loginFactory,
			$forgottenFactory
		);
	}


	public function actionDefault(): void
	{
		$this->getTemplate()->movies = $this->movieService->getMovies();
	}


	public function actionDetail(string $url): void
	{
		$this->getTemplate()->movie = $this->movieService->getMovieBySlug($url);
		$this->getTemplate()->otherMovies = $this->movieService->getMoviesByLimit(4);
	}


	public function handleMarkLast(string $url): void
	{
		if ($this->isLogged()) {
			$movie = $this->movieService->getMovieBySlug($url);
			$this->movieLastFacade->markLast($movie);
		}
		$this->redrawControl("last");
	}


	protected function createComponentLikeButton(): ButtonLike
	{
		$movie = $this->getMovieByUrl();

		$component = $this->buttonLikeFactory->create($movie);
		$component->onMarkLike[] = function (): void {
			$this->flashBasic("Přidáno");
			$this->redirectThis();
		};
		$component->onUnmarkLike[] = function (): void {
			$this->flashBasic("Odebráno");
			$this->redirectThis();
		};

		return $component;
	}


	protected function createComponentLaterButton(): ButtonLater
	{
		$movie = $this->getMovieByUrl();

		$component = $this->buttonLaterFactory->create($movie);
		$component->onMarkLater[] = function (): void {
			$this->flashBasic("Přidáno");
			$this->redirectThis();
		};
		$component->onUnmarkLater[] = function (): void {
			$this->flashBasic("Odebráno");
			$this->redirectThis();
		};

		return $component;
	}


	private function getMovieByUrl(): MovieEntity
	{
		$url = $this->getParameter("url");

		return $this->movieService->getMovieBySlug($url);
	}

}
