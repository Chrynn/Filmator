<?php declare(strict_types=1);

namespace App\Module;

use App\Model\Facade\Anonymous\Auth\AuthorizationFacade;
use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\FlashMessage;
use Nette\Application\UI\Presenter;

class ModulePresenter extends Presenter
{

	private readonly AutoIncrementFacade $autoIncrementFacade;
	private readonly PermanentLoginFacade $permanentLoginFacade;
	private readonly AuthorizationFacade $authorizationFacade;

	public function __construct(
		AutoIncrementFacade $autoIncrementFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade
	) {
		parent::__construct();
		$this->autoIncrementFacade = $autoIncrementFacade;
		$this->permanentLoginFacade = $permanentLoginFacade;
		$this->authorizationFacade = $authorizationFacade;
	}


	protected function beforeRender(): void
	{
		$this->autoIncrementFacade->resetAutoIncrement();
		$this->permanentLoginFacade->setPermanentLogin();

		$loginStatus = $this->authorizationFacade->isLoggedIn();
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
		$this->redirect(":Anonymous:Homepage:");
	}


	public function findLayoutTemplateFile(): ?string
	{
		return __DIR__ . '/templates/@layout.latte';
	}

}
