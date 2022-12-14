<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Serial;

use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Service\Serial\SerialService;
use App\Module\Anonymous\AnonymousPresenter;
use App\Module\Anonymous\components\Forgotten\ForgottenFactory;
use App\Module\Anonymous\components\Login\LoginFactory;
use App\Module\Anonymous\components\Register\RegisterFactory;
use App\Module\Anonymous\Serial\components\ButtonLater\ButtonLater;
use App\Module\Anonymous\Serial\components\ButtonLater\ButtonLaterFactory;
use App\Module\Anonymous\Serial\components\ButtonLike\ButtonLike;
use App\Module\Anonymous\Serial\components\ButtonLike\ButtonLikeFactory;

class SerialPresenter extends AnonymousPresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		RegisterFactory $registerFactory,
		LoginFactory $loginFactory,
		ForgottenFactory $forgottenFactory,
		private readonly SerialService $serialService,
		private readonly ButtonLikeFactory $buttonLikeFactory,
		private readonly ButtonLaterFactory $buttonLaterFactory
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


	protected function actionDefault()
	{
		$this->getTemplate()->serials = $this->serialService->getSerials();
	}


	public function actionDetail(string $url): void
	{
		$this->getTemplate()->serial = $this->serialService->getSerialBySlug($url);
		$this->getTemplate()->otherSerials = $this->serialService->getSerialsByLimit(4);
	}


	public function createComponentLikeButton(): ButtonLike
	{
		$url = $this->getParameter("url");
		$serial = $this->serialService->getSerialBySlug($url);

		$component = $this->buttonLikeFactory->create($serial);
		$component->onLike[] = function (): void {
			$this->flashMessage("l??b?? se", "success");
			$this->redirect("this");
		};
		$component->onDislike[] = function (): void {
			$this->flashMessage("nel??b?? se", "success");
			$this->redirect("this");
		};
		return $component;
	}


	protected function createComponentWatchButton(): ButtonLater
	{
		$url = $this->getParameter("url");
		$serial = $this->serialService->getSerialBySlug($url);

		$component = $this->buttonLaterFactory->create($serial);
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
