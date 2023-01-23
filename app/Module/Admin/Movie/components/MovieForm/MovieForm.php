<?php

declare(strict_types=1);

namespace App\Module\Admin\Movie\components\MovieForm;

use App\Model\Exception\ValueEmptyException;
use App\Model\Service\Movie\MovieService;
use Exception;
use Nette\Application\UI\Form;
use Nette\Utils\ImageException;

final class MovieForm
{

	public function __construct(
		private readonly MovieService $movieService,
		private readonly IOnSaveEvent $event,
	) {
	}


	public function getMovieForm(): Form
	{
		$form = new Form();

		$form->addText("name", "Název");
		$form->addText("year", "Rok")->addRule($form::NUMERIC, "Hodnota musí být číslo");
		$form->addText("rating", "Hodnocení")->addRule($form::NUMERIC, "Hodnota musí být číslo");
		$form->addText("trailer", "Trailer")->addRule($form::MAX_LENGTH, "Překročený limit znaků", 10);
		$form->addTextArea("description", "Popis");
		$form->addTextArea("teaser", "Upoutávka");
		$form->addUpload("banner", "Vybrat banner")->addRule($form::IMAGE);
		$form->addUpload("poster", "Vybrat poster")->addRule($form::IMAGE);
		$form->addSubmit("create", "vytvořit");
		$form->addSubmit("createAndShow", "vytvořit a zobrazit");
		$form->onSuccess[] = function (Form $form, MovieFormData $values): void
		{
			$movie = null;
			$valuesArray = $values->toArray();

			try {
				MovieFormData::validate($form);
				$movie = $this->movieService->save($valuesArray);
			} catch (ValueEmptyException) {
				$this->event->fire(false, message: "Vyplňte všechna požadovaná pole");
			} catch (ImageException) {
				$this->event->fire(false, message: "Nebyl nahrán obrázek");
			} catch (Exception) {
				$this->event->fire(false, message: "Vyskytla se chyba");
			}

			if ($movie !== NULL) {
				if ($form['createAndShow']->isSubmittedBy()) {
					$this->event->fire(true, $movie->getId());
				} else {
					$this->event->fire(true);
				}
			}

		};

		return $form;
	}

}