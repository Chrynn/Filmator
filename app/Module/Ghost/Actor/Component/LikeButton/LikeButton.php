<?php declare(strict_types = 1);

namespace App\Module\Ghost\Actor\Component\LikeButton;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Facade\LikeButton\LikeActorFacade;
use Nette\Application\UI\Control;

class LikeButton extends Control
{

	public array $onLike;
	public array $onDislike;

	private ActorEntity $actor;
	private LikeActorFacade $likeActorFacade;

	public function __construct(ActorEntity $actor, LikeActorFacade $likeActorFacade)
	{
		$this->actor = $actor;
		$this->likeActorFacade = $likeActorFacade;
	}

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
		$this->getTemplate()->setFile(__DIR__ . "/templates/likeButton.latte");
		$this->getTemplate()->render();
	}

}
