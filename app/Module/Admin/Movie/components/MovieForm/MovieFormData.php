<?php declare(strict_types = 1);

namespace App\Module\Admin\Movie\components\MovieForm;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Exception\EmptyValueException;
use App\Model\Exception\ValueEmptyException;
use Nette\Application\UI\Form;
use Nette\Forms\Validator;
use Nette\Http\FileUpload;
use Nette\Utils\Validators;

final class MovieFormData
{
	public function __construct(
		public string $name,
		public string|int $year,
		public string|int $rating,
		public string $trailer,
		public string $description,
		public string $teaser,
		public FileUpload $banner,
		public FileUpload $poster,
	) {
	}


	public function toArray(): array
	{
		return [
			"name" => $this->name,
			"year" => (int) $this->year,
			"rating" => (int) $this->rating,
			"trailer" => $this->trailer,
			"description" => $this->description,
			"teaser" => $this->teaser,
			"banner" => $this->banner,
			"poster" => $this->poster,
		];
	}


	/**
	 * @return array<string, mixed>
	 */
	public static function fillFormDataByMovie(MovieEntity $movie): array
	{
		return [
			'name' => $movie->getName(),
			'year' => $movie->getYear(),
			'rating' => $movie->getRating(),
			'trailer' => $movie->getTrailer(),
			'description' => $movie->getDescription(),
			'teaser' => $movie->getTeaser(),
		];
	}


	/**
	 * @throws ValueEmptyException
	 */
	public static function validate(Form $form): void
	{
		$validateEmptyMessage = "Vyplňte pole";

		$formValues = $form->getValues();

		if (Validators::isNone($formValues->name)) {
			$form["name"]->addError($validateEmptyMessage);

			throw new ValueEmptyException();
		}
	}

}