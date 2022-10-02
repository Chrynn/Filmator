<?php declare(strict_types=1);

namespace App\Module;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\PermanentLogin\PermanentLoginFacade;
use App\Model\FlashMessage;
use Nette\Application\UI\Presenter;

class ModulePresenter extends Presenter
{

	private AuthorizationFacade $authorizationFacade;
	private PermanentLoginFacade $permanentLoginFacade;
	private AutoIncrementFacade $autoIncrementFacade;


	public function __construct(
		AuthorizationFacade $authorizationFacade,
		PermanentLoginFacade $permanentLoginFacade,
		AutoIncrementFacade $autoIncrementFacade
	)
	{
		parent::__construct();
		$this->authorizationFacade = $authorizationFacade;
		$this->permanentLoginFacade = $permanentLoginFacade;
		$this->autoIncrementFacade = $autoIncrementFacade;
	}


	protected function beforeRender()
	{
		$this->autoIncrementFacade->resetAutoIncrement();
		$this->permanentLoginFacade->setPermanentLogin();

		$this->getTemplate()->isLogged = $this->authorizationFacade->isLoggedIn();;
		if ($this->authorizationFacade->isLoggedIn()) {
			$this->getTemplate()->isAdmin = $this->authorizationFacade->getLoggedUser()->getAdminRole();
			$this->getTemplate()->isEditor = $this->authorizationFacade->getLoggedUser()->getEditorRole();
			$this->getTemplate()->isUser = $this->authorizationFacade->getLoggedUser()->getUserRole();
		}
	}


	public function handleLoggOut(): void
	{
		$this->permanentLoginFacade->removePermanentLogin();
		$this->authorizationFacade->logout();
		$this->flashMessage("Úspěšně odhlášen", FlashMessage::TYPE_BASIC);
		$this->redirect(":Ghost:Homepage:");
	}


	public function findLayoutTemplateFile(): ?string
	{
		return __DIR__ . '/_template/@layout.latte';
	}

}
