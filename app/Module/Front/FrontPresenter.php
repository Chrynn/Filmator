<?php declare(strict_types = 1);

namespace App\Module\Front;

use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\FlashMessage;
use App\Module\Front\components\Forgotten\Forgotten;
use App\Module\Front\components\Forgotten\ForgottenFactory;
use App\Module\Front\components\Login\Login;
use App\Module\Front\components\Login\LoginFactory;
use App\Module\Front\components\Register\Register;
use App\Module\Front\components\Register\RegisterFactory;
use App\Module\ModulePresenter;

abstract class FrontPresenter extends ModulePresenter
{

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		protected readonly RegisterFactory $registerFactory,
		protected readonly LoginFactory $loginFactory,
		protected readonly ForgottenFactory $forgottenFactory
	) {
		parent::__construct(
			$autoIncrementFacade,
			$permanentLoginFacade,
			$authorizationFacade
		);
	}


	protected function createComponentRegister(): Register
	{
		return $this->registerFactory->create();
	}


	protected function createComponentLogin(): Login
	{
		$component = $this->loginFactory->create();
		$component->onLogin[] = function (): void {
			$this->flashBasic('Přihlášení bylo úspěšné');
			$this->redirect('this');
		};

		return $component;
	}


	protected function createComponentForgotten(): Forgotten
	{
		return $this->forgottenFactory->create();
	}

}
