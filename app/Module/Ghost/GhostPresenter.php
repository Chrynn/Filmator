<?php declare(strict_types = 1);

namespace App\Module\Ghost;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\FlashMessage;
use App\Module\Ghost\_component\Forgotten\Forgotten;
use App\Module\Ghost\_component\Forgotten\ForgottenFactory;
use App\Module\Ghost\_component\Login\Login;
use App\Module\Ghost\_component\Login\LoginFactory;
use App\Module\Ghost\_component\Register\Register;
use App\Module\Ghost\_component\Register\RegisterFactory;
use App\Module\ModulePresenter;


abstract class GhostPresenter extends ModulePresenter
{

	private LoginFactory $loginFactory;
	private RegisterFactory $registerFactory;
	private ForgottenFactory $forgottenFactory;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		LoginFactory $loginFactory,
		RegisterFactory $registerFactory,
		ForgottenFactory $forgottenFactory,
	)
	{
		parent::__construct($authorizationFacade);
		$this->loginFactory = $loginFactory;
		$this->registerFactory = $registerFactory;
		$this->forgottenFactory = $forgottenFactory;
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
