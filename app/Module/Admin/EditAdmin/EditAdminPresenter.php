<?php declare(strict_types = 1);

namespace App\Module\Admin\EditAdmin;

use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Module\Admin\AdminPresenter;
use Doctrine\ORM\EntityManagerInterface;

class EditAdminPresenter extends AdminPresenter
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager, AuthorizationFacade $authorizationFacade)
	{
		parent::__construct($authorizationFacade);
		$this->entityManager = $entityManager;
	}

	public function actionDefault(): void
	{
		$database = $this->entityManager->getRepository(UserEntity::class)->findAll();

		$this->getTemplate()->users = $database;
	}

}
