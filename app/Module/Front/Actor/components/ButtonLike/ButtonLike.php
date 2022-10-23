<?php declare(strict_types = 1);

namespace App\Module\Front\Actor\components\ButtonLike;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Facade\User\Like\ActorLikeFacade;
use Nette\Application\UI\Control;

class ButtonLike extends Control
{

	public array $onLike;
	public array $onDislike;


	public function __construct(
		private readonly ActorEntity $actor,
		private readonly ActorLikeFacade $actorLikeFacade
	) {}


	public function handleLike(): void
	{
		$this->actorLikeFacade->like($this->actor);
		$this->onLike();
	}


	public function handleUnLike(): void
	{
		$this->actorLikeFacade->unLike($this->actor);
		$this->onDislike();
	}


	public function render(): void
	{
		$this->getTemplate()->liked = $this->actorLikeFacade->isLiked($this->actor);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLike.latte");
		$this->getTemplate()->render();
	}

}
