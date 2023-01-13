<?php declare(strict_types=1);

namespace App\Module\Front\Serial\components\ButtonLike;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\User\Like\SerialLikeFacade;
use Nette\Application\UI\Control;

class ButtonLike extends Control
{

    public array $onMarkLike;
    public array $onUnmarkLike;


	public function __construct(
		private readonly SerialEntity $serial,
		private readonly SerialLikeFacade $serialLikeFacade
	) {}


    public function handleMarkLike(): void
    {
        $this->serialLikeFacade->markLike($this->serial);
        $this->onMarkLike();
    }


    public function handleUnmarkLike(): void
    {
        $this->serialLikeFacade->unmarkLike($this->serial);
        $this->onUnmarkLike();
    }


    public function render(): void
    {
        $this->getTemplate()->liked = $this->serialLikeFacade->isMarkedLike($this->serial);

        $this->getTemplate()->setFile(__DIR__ . "/templates/buttonLike.latte");
        $this->getTemplate()->render();
    }

}
