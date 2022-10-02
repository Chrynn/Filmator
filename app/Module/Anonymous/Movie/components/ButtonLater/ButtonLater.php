<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Movie\components\ButtonLater;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\User\ButtonLater\LaterMovieFacade;
use Nette\Application\UI\Control;

class ButtonLater extends Control
{

	public array $onWatch;
	public array $onUnWatch;

	private MovieEntity $movie;
	private LaterMovieFacade $laterMovieFacade;


	public function __construct(
		MovieEntity $movie,
		LaterMovieFacade $laterMovieFacade
	)
	{
		$this->movie = $movie;
		$this->laterMovieFacade = $laterMovieFacade;
	}


	public function handleWatch(): void
	{
		$this->laterMovieFacade->watch($this->movie);
		$this->onWatch();
	}


	public function handleUnWatch(): void
	{
		$this->laterMovieFacade->unWatch($this->movie);
		$this->onUnWatch();
	}


	public function render(): void
	{
		$this->getTemplate()->wantWatch = $this->laterMovieFacade->wantWatch($this->movie);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLater.latte");
		$this->getTemplate()->render();
	}

}
