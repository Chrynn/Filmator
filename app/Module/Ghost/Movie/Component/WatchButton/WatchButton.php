<?php declare(strict_types = 1);

namespace App\Module\Ghost\Movie\Component\WatchButton;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\WatchButton\WatchMovieFacade;
use Nette\Application\UI\Control;

class WatchButton extends Control
{

	public array $onWatch;
	public array $onUnWatch;

	private MovieEntity $movie;
	private WatchMovieFacade $watchMovieFacade;

	public function __construct(MovieEntity $movie, WatchMovieFacade $watchMovieFacade)
	{
		$this->movie = $movie;
		$this->watchMovieFacade = $watchMovieFacade;
	}

	public function handleWatch(): void
	{
		$this->watchMovieFacade->watch($this->movie);
		$this->onWatch();
	}

	public function handleUnWatch(): void
	{
		$this->watchMovieFacade->unWatch($this->movie);
		$this->onUnWatch();
	}

	public function render(): void
	{
		$this->getTemplate()->wantWatch = $this->watchMovieFacade->wantWatch($this->movie);
		$this->getTemplate()->setFile(__DIR__ . "/templates/watchButton.latte");
		$this->getTemplate()->render();
	}

}
