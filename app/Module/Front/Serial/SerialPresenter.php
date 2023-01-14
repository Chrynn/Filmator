<?php declare(strict_types = 1);

namespace App\Module\Front\Serial;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Facade\User\Last\SerialLastFacade;
use App\Model\Service\Serial\SerialService;
use App\Module\Front\components\Forgotten\ForgottenFactory;
use App\Module\Front\components\Login\LoginFactory;
use App\Module\Front\components\Register\RegisterFactory;
use App\Module\Front\FrontPresenter;
use App\Module\Front\Serial\components\ButtonLater\ButtonLater;
use App\Module\Front\Serial\components\ButtonLater\ButtonLaterFactory;
use App\Module\Front\Serial\components\ButtonLike\ButtonLike;
use App\Module\Front\Serial\components\ButtonLike\ButtonLikeFactory;

class SerialPresenter extends FrontPresenter
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
		private readonly ButtonLaterFactory $buttonLaterFactory,
		private readonly SerialLastFacade $serialLastFacade
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


	protected function actionDefault(): void
	{
		$this->getTemplate()->serials = $this->serialService->getSerials();
	}


	public function actionDetail(string $url): void
	{
		$this->getTemplate()->serial = $this->serialService->getSerialBySlug($url);
		$this->getTemplate()->otherSerials = $this->serialService->getSerialsByLimit(4);
		$this->getTemplate()->showMarkLast = true;
	}


	public function handleMarkLast(string $url): void
	{
		if ($this->isLogged()) {
			$serial = $this->serialService->getSerialBySlug($url);
			$this->serialLastFacade->markLast($serial);
		}
		$this->redrawControl("markLast");
		$this->getTemplate()->showMarkLast = false;
	}


	public function createComponentLikeButton(): ButtonLike
	{
		$serial = $this->getSerialByUrl();

		$component = $this->buttonLikeFactory->create($serial);
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
		$serial = $this->getSerialByUrl();

		$component = $this->buttonLaterFactory->create($serial);
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


	private function getSerialByUrl(): SerialEntity
	{
		$url = $this->getParameter("url");

		return $this->serialService->getSerialBySlug($url);
	}

}
