<?php declare(strict_types = 1);

namespace App\Module\Ghost;

use App\Model\Facade\Admin\NewContentFacade;
use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Path\PathFacade;
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
	private PathFacade $pathFacade;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		LoginFactory $loginFactory,
		RegisterFactory $registerFactory,
		ForgottenFactory $forgottenFactory,
		PathFacade $pathFacade,
	)
	{
		parent::__construct($authorizationFacade, $pathFacade);
		$this->loginFactory = $loginFactory;
		$this->registerFactory = $registerFactory;
		$this->forgottenFactory = $forgottenFactory;
		$this->pathFacade = $pathFacade;
	}

	public function beforeRender()
	{
		parent::beforeRender();
		$this->getTemplate()->module = $this->pathFacade->getModuleActive();
	}

	protected function createComponentRegister(): Register
	{
		$component = $this->registerFactory->create();
		$component->onRegister[] = function (): void {
			$this->flashMessage("Úspěšná registrace, přihlaste se", FlashMessage::TYPE_BASIC);
			$this->redirect("this");
		};
		return $component;
	}

	protected function createComponentLogin(): Login
	{
		$component = $this->loginFactory->create();
		$component->onLogin[] = function (): void {
			$this->flashMessage('Přihlášení bylo úspěšné', FlashMessage::TYPE_BASIC);
			$this->redirect(':User:Homepage:');
		};
		return $component;
	}

	protected function createComponentForgotten(): Forgotten
	{
		$component = $this->forgottenFactory->create();
		$component->onForgotten[] = function (): void {
			$this->flashMessage('Heslo bylo odesláno na E-mail', FlashMessage::TYPE_BASIC);
		};
		return $component;
	}

}
