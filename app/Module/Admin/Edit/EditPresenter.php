<?php

namespace App\Module\Admin\Edit;

use App\Model\Database\Entity\Movie;
use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Auth\AuthorizationFacade;
use App\Module\Admin\AdminPresenter;
use App\Module\Admin\Edit\Component\EditMovie\EditMovie;
use App\Module\Admin\Edit\Component\EditMovie\EditMovieFactory;
use Doctrine\ORM\EntityManagerInterface;

class EditPresenter extends AdminPresenter
{

	private EntityManagerInterface $entityManager;
	private EditMovieFactory $editMovieFactory;

	public function __construct(
		EntityManagerInterface $entityManager,
		EditMovieFactory $editMovieFactory,
		AuthorizationFacade $authorizationFacade,
	)
	{
		parent::__construct($authorizationFacade);
		$this->entityManager = $entityManager;
		$this->editMovieFactory = $editMovieFactory;
	}

	public function actionDefault(int $id): void
	{
		$movie = $this->entityManager->getRepository(MovieEntity::class)->find($id);

		if($movie === null)
		{
			$this->flashMessage("film nebyl nalezen", "error");
			$this->redirect(":Admin:Homepage:");
		}

	}

	protected function createComponentEditMovie(): EditMovie
	{
		$movie = $this->entityManager->getRepository(MovieEntity::class)->find($this->getParameter("id"));
		return $this->editMovieFactory->create($movie);
	}

}
