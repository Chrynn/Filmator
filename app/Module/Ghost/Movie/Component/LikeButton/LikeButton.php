<?php declare(strict_types = 1);

namespace App\Module\Ghost\Movie\Component\LikeButton;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\LikeButton\LikeMovieFacade;
use Nette\Application\UI\Control;

class LikeButton extends Control
{

	public array $onLike;
	public array $onDislike;

	private MovieEntity $movie;
	private LikeMovieFacade $likeMovieFacade;

	public function __construct(MovieEntity $movie, LikeMovieFacade $likeMovieFacade)
	{
		$this->movie = $movie;
		$this->likeMovieFacade = $likeMovieFacade;
	}

	public function handleLike(): void
	{
		$this->likeMovieFacade->like($this->movie);
		$this->onLike();
	}

	public function handleDislike(): void
	{
		$this->likeMovieFacade->dislike($this->movie);
		$this->onDislike();
	}

	public function render(): void
	{
		$this->getTemplate()->liked = $this->likeMovieFacade->isLiked($this->movie);
		$this->getTemplate()->setFile(__DIR__ . "/templates/likeButton.latte");
		$this->getTemplate()->render();
	}

}
