<?php declare(strict_types = 1);

namespace App\Module\Admin\Edit\Component\EditMovie;

use App\Model\Database\Entity\MovieEntity;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class EditMovie extends Control
{

	private EntityManagerInterface $entityManager;
	private MovieEntity $movie;

	public function __construct(MovieEntity $movie, EntityManagerInterface $entityManager)
	{

		$this->entityManager = $entityManager;
		$this->movie = $movie;
	}

	protected function createComponentForm(): Form
	{
		$form = new Form();
		$form->addText("name", "Jméno");
		$form->addTextArea("description", "Popis");
		$form->addSubmit("send", "Odeslat");
		$form->onRender[] = [$this, "fillForm"];
		$form->onSubmit[] = [$this, "processForm"];
		return $form;
	}

	public function fillForm(Form $form): void
	{

		$form->setDefaults([
			"name" => $this->movie->getName(),
			"description" => $this->movie->getDescription(),
		]);
	}

	public function processForm(Form $form): void
	{
		$values = $form->getValues();

		$this->movie->setName($values->name);
		$this->movie->setDescription($values->description);
		$this->entityManager->flush();
		$this->presenter->flashMessage("Upraveno");
		$this->presenter->redirect(":Anonymous:Movie:detail", $this->movie->getSlug());
	}

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . "/templates/editMovie.latte");
		$this->getTemplate()->render();
	}

}
