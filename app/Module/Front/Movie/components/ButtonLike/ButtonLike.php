<?php declare(strict_types = 1);

namespace App\Module\Front\Movie\components\ButtonLike;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\User\Like\MovieLikeFacade;
use Nette\Application\UI\Control;

final class ButtonLike extends Control
{

	public array $onMarkLike;
	public array $onUnmarkLike;


	public function __construct(
		private readonly MovieEntity $movie,
		private readonly MovieLikeFacade $movieLikeFacade
	) {}


	public function handleMarkLike(): void
	{
		$this->movieLikeFacade->markLike($this->movie);
		$this->onMarkLike();
	}


	public function handleUnmarkLike(): void
	{
		$this->movieLikeFacade->unmarkLike($this->movie);
		$this->onUnmarkLike();
	}


	public function render(): void
	{
		$this->getTemplate()->liked = $this->movieLikeFacade->isMarkLike($this->movie);

		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLike.latte");
		$this->getTemplate()->render();
	}

}
