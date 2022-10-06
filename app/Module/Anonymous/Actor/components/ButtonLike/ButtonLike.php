<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Actor\components\ButtonLike;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Facade\User\ButtonLike\LikeActorFacade;
use Nette\Application\UI\Control;

class ButtonLike extends Control
{

	public array $onLike;
	public array $onDislike;


	public function __construct(
		private readonly ActorEntity $actor,
		private readonly LikeActorFacade $likeActorFacade
	) {}


	public function handleLike(): void
	{
		$this->likeActorFacade->like($this->actor);
		$this->onLike();
	}


	public function handleDislike(): void
	{
		$this->likeActorFacade->dislike($this->actor);
		$this->onDislike();
	}


	public function render(): void
	{
		$this->getTemplate()->liked = $this->likeActorFacade->isLiked($this->actor);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLike.latte");
		$this->getTemplate()->render();
	}

}
