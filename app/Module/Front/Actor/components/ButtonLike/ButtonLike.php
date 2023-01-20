<?php declare(strict_types = 1);

namespace App\Module\Front\Actor\components\ButtonLike;

use App\Model\Database\Entity\ActorEntity;
use App\Model\Facade\User\Like\ActorLikeFacade;
use Nette\Application\UI\Control;

class ButtonLike extends Control
{

	public array $onMarkLike;
	public array $onUnmarkLike;


	public function __construct(
		private readonly ActorEntity $actor,
		private readonly ActorLikeFacade $actorLikeFacade
	) {}


	public function handleMarkLike(): void
	{
		$this->actorLikeFacade->markLike($this->actor);
		$this->onMarkLike();
	}


	public function handleUnmarkLike(): void
	{
		$this->actorLikeFacade->unmarkLike($this->actor);
		$this->onUnmarkLike();
	}


	public function render(): void
	{
		$this->getTemplate()->liked = $this->actorLikeFacade->isMarkedLike($this->actor);

		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLike.latte");
		$this->getTemplate()->render();
	}

}
