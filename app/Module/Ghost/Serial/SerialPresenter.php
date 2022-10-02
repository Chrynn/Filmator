<?php declare(strict_types = 1);

namespace App\Module\Ghost\Serial;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Query\SerialEntityQuery;
use App\Module\Ghost\_component\Forgotten\ForgottenFactory;
use App\Module\Ghost\_component\Login\LoginFactory;
use App\Module\Ghost\_component\Register\RegisterFactory;
use App\Module\Ghost\GhostPresenter;
use App\Module\Ghost\Serial\Component\LikeButton\LikeButton;
use App\Module\Ghost\Serial\Component\LikeButton\LikeButtonFactory;
use App\Module\Ghost\Serial\Component\WatchButton\WatchButton;
use App\Module\Ghost\Serial\Component\WatchButton\WatchButtonFactory;


class SerialPresenter extends GhostPresenter
{

	private SerialEntityQuery $serialEntityQuery;
	private LikeButtonFactory $likeButtonFactory;
	private WatchButtonFactory $watchButtonFactory;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AutoIncrementFacade $autoIncrementFacade,
		ForgottenFactory $forgottenFactory,
		LoginFactory $loginFactory,
		RegisterFactory $registerFactory,
		SerialEntityQuery $serialEntityQuery,
		LikeButtonFactory $likeButtonFactory,
		WatchButtonFactory $watchButtonFactory
	)
	{
		parent::__construct(
			$authorizationFacade,
			$permanentLoginFacade,
			$autoIncrementFacade,
			$forgottenFactory,
			$loginFactory,
			$registerFactory
		);
		$this->serialEntityQuery = $serialEntityQuery;
		$this->likeButtonFactory = $likeButtonFactory;
		$this->watchButtonFactory = $watchButtonFactory;
	}


	protected function actionDefault()
	{
		$this->getTemplate()->serials = $this->serialEntityQuery->getSerials();
	}


	public function actionDetail(string $url): void
	{
		$this->getTemplate()->serial = $this->serialEntityQuery->getSerialBySlug($url);
		$this->getTemplate()->otherSerials = $this->serialEntityQuery->getSerialsByLimit(4);
	}


	public function createComponentLikeButton(): LikeButton
	{
		$url = $this->getParameter("url");
		$serial = $this->serialEntityQuery->getSerialBySlug($url);

		$component = $this->likeButtonFactory->create($serial);
		$component->onLike[] = function (): void {
			$this->flashMessage("líbí se", "success");
			$this->redirect("this");
		};
		$component->onDislike[] = function (): void {
			$this->flashMessage("nelíbí se", "success");
			$this->redirect("this");
		};
		return $component;
	}


	protected function createComponentWatchButton(): WatchButton
	{
		$url = $this->getParameter("url");
		$serial = $this->serialEntityQuery->getSerialBySlug($url);

		$component = $this->watchButtonFactory->create($serial);
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
