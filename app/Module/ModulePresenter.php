<?php declare(strict_types=1);

namespace App\Module;

use App\Model\Facade\Auth\AuthorizationFacade;
use App\Model\Facade\Path\PathFacade;
use App\Model\FlashMessage;
use Nette\Application\UI\Presenter;

class ModulePresenter extends Presenter
{

	private AuthorizationFacade $authorizationFacade;
	private PathFacade $pathFacade;

	public function __construct(
		AuthorizationFacade $authorizationFacade,
		PathFacade $pathFacade,
	)
	{
		parent::__construct();
		$this->authorizationFacade = $authorizationFacade;
		$this->pathFacade = $pathFacade;
	}

	protected function beforeRender()
	{
		$this->getTemplate()->basePath = $this->pathFacade->getBasePath();
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
