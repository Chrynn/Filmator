<?php declare(strict_types = 1);

namespace App\Module\Anonymous;

use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\FlashMessage;
use App\Module\Anonymous\components\Forgotten\Forgotten;
use App\Module\Anonymous\components\Forgotten\ForgottenFactory;
use App\Module\Anonymous\components\Login\Login;
use App\Module\Anonymous\components\Login\LoginFactory;
use App\Module\Anonymous\components\Register\Register;
use App\Module\Anonymous\components\Register\RegisterFactory;
use App\Module\ModulePresenter;

abstract class AnonymousPresenter extends ModulePresenter
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
			$this->flashMessage('Přihlášení bylo úspěšné', FlashMessage::TYPE_BASIC);
			$this->redirect('this');
		};

		return $component;
	}


	protected function createComponentForgotten(): Forgotten
	{
		return $this->forgottenFactory->create();
	}

}
