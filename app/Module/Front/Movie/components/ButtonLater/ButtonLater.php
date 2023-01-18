<?php declare(strict_types = 1);

namespace App\Module\Front\Movie\components\ButtonLater;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\User\Later\LaterMovieFacade;
use Nette\Application\UI\Control;

class ButtonLater extends Control
{

	public array $onMarkLater;
	public array $onUnmarkLater;


	public function __construct(
		private readonly MovieEntity $movie,
		private readonly LaterMovieFacade $laterMovieFacade
	) {}


	public function handleMarkLater(): void
	{
		$this->laterMovieFacade->markLater($this->movie);
		$this->onMarkLater();
	}


	public function handleUnmarkLater(): void
	{
		$this->laterMovieFacade->unmarkLater($this->movie);
		$this->onUnmarkLater();
	}


	public function render(): void
	{
		$this->getTemplate()->later = $this->laterMovieFacade->isMarkedLater($this->movie);

		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLater.latte");
		$this->getTemplate()->render();
	}

}
