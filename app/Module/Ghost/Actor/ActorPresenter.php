<?php declare(strict_types=1);

namespace App\Module\Ghost\Actor;

use App\Model\Service\Query\ActorEntityQuery;
use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Path\PathFacade;
use App\Model\Service\Query\MovieEntityQuery;
use App\Module\Ghost\_component\Forgotten\ForgottenFactory;
use App\Module\Ghost\_component\Login\LoginFactory;
use App\Module\Ghost\_component\Register\RegisterFactory;
use App\Module\Ghost\Actor\Component\LikeButton\LikeButton;
use App\Module\Ghost\Actor\Component\LikeButton\LikeButtonFactory;
use App\Module\Ghost\GhostPresenter;


class ActorPresenter extends GhostPresenter
{

    private LikeButtonFactory $likeButtonFactory;
	private ActorEntityQuery $actorEntityQuery;
	private MovieEntityQuery $movieEntityQuery;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		LoginFactory $loginFactory,
		RegisterFactory $registerFactory,
		LikeButtonFactory $likeButtonFactory,
		ActorEntityQuery $actorEntityQuery,
		MovieEntityQuery $movieEntityQuery,
		PathFacade $pathFacade,
		ForgottenFactory $forgottenFactory
	)
	{
    	parent::__construct($authorizationFacade, $loginFactory, $registerFactory, $forgottenFactory, $pathFacade);
    	$this->likeButtonFactory = $likeButtonFactory;
		$this->actorEntityQuery = $actorEntityQuery;
		$this->movieEntityQuery = $movieEntityQuery;
	}

    protected function actionDefault(): void
	{
		$this->getTemplate()->actors = $this->actorEntityQuery->getActors();
	}

    public function actionDetail(string $url): void
	{
        $this->getTemplate()->actor = $this->actorEntityQuery->getActorBySlug($url);
		$this->getTemplate()->movies = $this->movieEntityQuery->getMovies();
    }

    protected function createComponentLikeButton(): LikeButton
    {
    	$url = $this->getParameter("url");
        $actor = $this->actorEntityQuery->getActorBySlug($url);

        $component = $this->likeButtonFactory->create($actor);
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
