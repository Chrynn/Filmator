<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Movie;

use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Movie\MovieService;
use App\Module\Anonymous\AnonymousPresenter;
use App\Module\Anonymous\components\Forgotten\ForgottenFactory;
use App\Module\Anonymous\components\Login\LoginFactory;
use App\Module\Anonymous\components\Register\RegisterFactory;
use App\Module\Anonymous\Movie\components\ButtonLater\ButtonLater;
use App\Module\Anonymous\Movie\components\ButtonLater\ButtonLaterFactory;
use App\Module\Anonymous\Movie\components\ButtonLike\ButtonLike;
use App\Module\Anonymous\Movie\components\ButtonLike\ButtonLikeFactory;

class MoviePresenter extends AnonymousPresenter
{

	private MovieService $movieService;
	private ButtonLaterFactory $buttonLaterFactory;
	private ButtonLikeFactory $buttonLikeFactory;

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		RegisterFactory $registerFactory,
		LoginFactory $loginFactory,
		ForgottenFactory $forgottenFactory,
		MovieService $movieService,
		ButtonLaterFactory $buttonLaterFactory,
		ButtonLikeFactory $buttonLikeFactory
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
		$this->movieService = $movieService;
		$this->buttonLaterFactory = $buttonLaterFactory;
		$this->buttonLikeFactory = $buttonLikeFactory;
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


	protected function createComponentLikeButton(): ButtonLike
	{
		$url = $this->getParameter("url");
		$movie = $this->movieService->getMovieBySlug($url);

		$component = $this->buttonLikeFactory->create($movie);
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


	protected function createComponentWatchButton(): ButtonLater
	{
		$url = $this->getParameter("url");
		$movie = $this->movieService->getMovieBySlug($url);

		$component = $this->buttonLaterFactory->create($movie);
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
