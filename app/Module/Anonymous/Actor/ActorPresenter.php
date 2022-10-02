<?php declare(strict_types=1);

namespace App\Module\Anonymous\Actor;

use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Actor\ActorService;
use App\Model\Service\Movie\MovieService;
use App\Module\Anonymous\Actor\components\ButtonLike\ButtonLike;
use App\Module\Anonymous\Actor\components\ButtonLike\ButtonLikeFactory;
use App\Module\Anonymous\AnonymousPresenter;
use App\Module\Anonymous\components\Forgotten\ForgottenFactory;
use App\Module\Anonymous\components\Login\LoginFactory;
use App\Module\Anonymous\components\Register\RegisterFactory;

class ActorPresenter extends AnonymousPresenter
{

	private ActorService $actorService;
	private MovieService $movieService;
	private ButtonLikeFactory $buttonLikeFactory;


	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		RegisterFactory $registerFactory,
		LoginFactory $loginFactory,
		ForgottenFactory $forgottenFactory,
		ActorService $actorService,
		MovieService $movieService,
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
		$this->actorService = $actorService;
		$this->movieService = $movieService;
		$this->buttonLikeFactory = $buttonLikeFactory;
	}


    protected function actionDefault(): void
	{
		$this->getTemplate()->actors = $this->actorService->getActors();
	}


    public function actionDetail(string $url): void
	{
        $this->getTemplate()->actor = $this->actorService->getActorBySlug($url);
		$this->getTemplate()->otherMovies = $this->movieService->getMovies();
    }


    protected function createComponentButtonLike(): ButtonLike
    {
    	$url = $this->getParameter("url");
        $actor = $this->actorService->getActorBySlug($url);

        $component = $this->buttonLikeFactory->create($actor);
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

}
