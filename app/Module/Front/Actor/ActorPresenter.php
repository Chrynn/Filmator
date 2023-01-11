<?php declare(strict_types=1);

namespace App\Module\Front\Actor;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Actor\ActorService;
use App\Model\Service\Movie\MovieService;
use App\Module\Front\Actor\components\ButtonLike\ButtonLike;
use App\Module\Front\Actor\components\ButtonLike\ButtonLikeFactory;
use App\Module\Front\components\Forgotten\ForgottenFactory;
use App\Module\Front\components\Login\LoginFactory;
use App\Module\Front\components\Register\RegisterFactory;
use App\Module\Front\FrontPresenter;

class ActorPresenter extends FrontPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		RegisterFactory $registerFactory,
		LoginFactory $loginFactory,
		ForgottenFactory  $forgottenFactory,
		private readonly ActorService $actorService,
		private readonly MovieService $movieService,
		private readonly ButtonLikeFactory $buttonLikeFactory
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
		$this->getTemplate()->actors = $this->actorService->getActors();
	}


    public function actionDetail(string $url): void
	{
        $this->getTemplate()->actor = $this->actorService->getActorBySlug($url);
		$this->getTemplate()->otherMovies = $this->movieService->getMovies();
    }


    protected function createComponentButtonLike(): ButtonLike
    {
    	$actor = $this->getActorByUrl();

        $component = $this->buttonLikeFactory->create($actor);
        $component->onMarkLike[] = function(): void{
            $this->flashBasic("Přidáno");
            $this->redirectThis();
        };
        $component->onUnmarkLike[] = function(): void{
            $this->flashBasic("Odebráno");
            $this->redirectThis();
        };
        return $component;
    }


	private function getActorByUrl(): ActorEntity
	{
		$url = $this->getParameter("url");

		return $this->actorService->getActorBySlug($url);
	}

}
