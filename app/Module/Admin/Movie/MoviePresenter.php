<?php

declare(strict_types=1);

namespace App\Module\Admin\Movie;

use App\Model\Facade\Common\AutoIncrement\AutoIncrementFacade;
use App\Model\Facade\Common\PermanentLogin\PermanentLoginFacade;
use App\Model\Facade\Front\Auth\AuthorizationFacade;
use App\Model\Service\Movie\MovieService;
use App\Module\Admin\AdminPresenter;
use App\Module\Admin\Movie\components\MovieForm\IOnSaveEvent;
use App\Module\Admin\Movie\components\MovieForm\MovieForm;
use App\Module\Admin\Movie\components\MovieForm\MovieFormData;
use App\Module\Admin\Movie\components\MovieForm\MovieFormFactory;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

class MoviePresenter extends AdminPresenter
{
	public function __construct(
		PermanentLoginFacade $permanentLoginFacade,
		AuthorizationFacade $authorizationFacade,
		private MovieService $movieService,
		private MovieFormFactory $movieFormFactory
	) {
		parent::__construct(
			$permanentLoginFacade,
			$authorizationFacade
		);
	}

	public function actionDefault(): void
	{

	}


	public function actionCreate(): void
	{

	}


	public function actionEdit(int $id): void
	{

	}

	public function createComponentMovieGrid(): DataGrid
	{
		$grid = new DataGrid();

		$movies = $this->movieService->getMoviesByOrder("DESC");

		$grid->setDataSource($movies);
		$grid->addColumnText("id", "ID");
		$grid->addColumnLink("name", "jméno", ":Front:Movie:detail", params: ["url" => "slug"])->setSortable()->setFilterText()->setPlaceholder("hledat");
		$grid->addColumnText("year", "rok")->setFilterText()->setPlaceholder("hledat");
		$grid->addColumnDateTime("createdAt", "vytvořeno")->setFormat("d. m. Y - H:m");
		$grid->addColumnDateTime("editedAt", "upraveno")->setFormat("d. m. Y - H:m");
		$grid->addAction("edit", "upravit");

		$grid->setRememberState(false);
		$grid->setDefaultPerPage(20);

		return $grid;
	}


	protected function createComponentMovieForm(): Form
	{
		$event = new class ($this) implements IOnSaveEvent {

			public function __construct(private readonly MoviePresenter $presenter)
			{
			}

			public function fire(bool $success, ?int $id = null, ?string $message = null): void
			{
				if ($success) {
					$this->presenter->flashMessage("Úspěšně přidáno", "success");

					if ($id) {
						$this->presenter->redirect(":Admin:Homepage:", ["id" => $id]);
					} else {
						$this->presenter->redirect(":Admin:Movie:");
					}
				} else {
					$this->presenter->flashMessage($message ?? "Nebyla uvedena příčina chyby");
				}
			}

		};

		$movieFormFactory = $this->movieFormFactory->create($event);
		$movieForm = $movieFormFactory->getMovieForm();

		$movieId = $this->getParameter("id");

		if ($movieId !== null) {
			$movie = $this->movieService->findMovieById((int) $movieId);
			if ($movie !== NULL) {
				$movieForm->onRender[] = static function () use ($movieForm, $movie) {
					$movieForm->setDefaults(MovieFormData::fillFormDataByMovie($movie));
				};
			}
		}


		return $movieForm;
	}

}