<?php declare(strict_types = 1);

namespace App\Module\Front\Movie\components\ButtonLater;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\User\ButtonLater\LaterMovieFacade;
use Nette\Application\UI\Control;

class ButtonLater extends Control
{

	public array $onLater;
	public array $onUnLater;


	public function __construct(
		private readonly MovieEntity $movie,
		private readonly LaterMovieFacade $laterMovieFacade
	) {}


	public function handleLater(): void
	{
		$this->laterMovieFacade->later($this->movie);
		$this->onLater();
	}


	public function handleUnLater(): void
	{
		$this->laterMovieFacade->unLater($this->movie);
		$this->onUnLater();
	}


	public function render(): void
	{
		$this->getTemplate()->later = $this->laterMovieFacade->laterMarked($this->movie);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLater.latte");
		$this->getTemplate()->render();
	}

}
