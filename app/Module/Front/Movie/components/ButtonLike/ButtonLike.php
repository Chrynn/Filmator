<?php declare(strict_types = 1);

namespace App\Module\Front\Movie\components\ButtonLike;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\User\Like\MovieLikeFacade;
use Nette\Application\UI\Control;

class ButtonLike extends Control
{

	public array $onLike;
	public array $onDislike;


	public function __construct(
		private readonly MovieEntity $movie,
		private readonly MovieLikeFacade $movieLikeFacade
	) {}


	public function handleLike(): void
	{
		$this->movieLikeFacade->like($this->movie);
		$this->onLike();
	}


	public function handleUnLike(): void
	{
		$this->movieLikeFacade->unLike($this->movie);
		$this->onDislike();
	}


	public function render(): void
	{
		$this->getTemplate()->liked = $this->movieLikeFacade->isLiked($this->movie);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLike.latte");
		$this->getTemplate()->render();
	}

}
