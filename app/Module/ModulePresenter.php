<?php declare(strict_types=1);

namespace App\Module;

use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\FlashMessage;
use App\Module\Front\components\Forgotten\Forgotten;
use App\Module\Front\components\Login\Login;
use App\Module\Front\components\Register\Register;
use Exception;
use Nette\Application\UI\Presenter;
use Nette\Security\User;

class ModulePresenter extends Presenter
{

	private readonly PermanentLoginFacade $permanentLoginFacade;
	private readonly AuthorizationFacade $authorizationFacade;

	public function __construct(
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade
	) {
		parent::__construct();
		$this->permanentLoginFacade = $permanentLoginFacade;
		$this->authorizationFacade = $authorizationFacade;
	}


	protected function beforeRender(): void
	{
		$this->permanentLoginFacade->setPermanentLogin();

		$loginStatus = $this->isLogged();
		$this->getTemplate()->isLogged = $loginStatus;
		if ($loginStatus) {
			$role = $this->authorizationFacade->getLoggedUser()->getRole();
			$this->getTemplate()->isAdmin = $role === "admin";
			$this->getTemplate()->isDeveloper = $role === "developer";
			$this->getTemplate()->isUser = $role === "user";
		}
	}


	public function handleLogout(): void
	{
		$this->permanentLoginFacade->removePermanentLogin();
		$this->authorizationFacade->logout();
		$this->flashMessage("Úspěšně odhlášen", FlashMessage::TYPE_BASIC);
		$this->redirect(":Front:Homepage:");
	}


	protected function flashBasic(string $message): void
	{
		$this->flashMessage($message, FlashMessage::TYPE_BASIC);
	}


	protected function redirectThis(): void
	{
		$this->redirect("this");
	}


	protected function isLogged(): bool
	{
		return $this->authorizationFacade->isLoggedIn();
	}


	/**
	 * @throws Exception
	 */
	protected function getLoggedUser(): UserEntity
	{
		return $this->authorizationFacade->getLoggedUser();
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


	public function findLayoutTemplateFile(): ?string
	{
		return __DIR__ . '/templates/@layout.latte';
	}

}
