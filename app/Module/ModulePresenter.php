<?php declare(strict_types=1);

namespace App\Module;

use App\Model\CookieID;
use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\FlashMessage;
use Nette\Application\UI\Presenter;
use Nette\Http\Request;

class ModulePresenter extends Presenter
{

	private AuthorizationFacade $authorizationFacade;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
	)
	{
		parent::__construct();
		$this->authorizationFacade = $authorizationFacade;
	}

	protected function beforeRender()
	{
		$this->getTemplate()->isLogged = $this->authorizationFacade->isLoggedIn();
		if ($this->authorizationFacade->isLoggedIn()) {
			$this->getTemplate()->isAdmin = $this->authorizationFacade->getLoggedUser()->getAdminRole();
			$this->getTemplate()->isEditor = $this->authorizationFacade->getLoggedUser()->getEditorRole();
			$this->getTemplate()->isUser = $this->authorizationFacade->getLoggedUser()->getUserRole();
		}
	}

	public function handleLoggOut(): void
	{
		$this->authorizationFacade->logout();
		$this->flashMessage("Úspěšně odhlášen", FlashMessage::TYPE_BASIC);
		$this->redirect(":Ghost:Homepage:");
	}


	public function findLayoutTemplateFile(): ?string
	{
		return __DIR__ . '/_template/@layout.latte';
	}

}
