<?php declare(strict_types=1);

namespace App\Module\Front\Serial\components\ButtonLike;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\User\Like\SerialLikeFacade;
use Nette\Application\UI\Control;

class ButtonLike extends Control
{

    public array $onLike;
    public array $onDislike;


	public function __construct(
		private readonly SerialEntity $serial,
		private readonly SerialLikeFacade $serialLikeFacade
	) {}


    public function handleLike(): void
    {
        $this->serialLikeFacade->like($this->serial);
        $this->onLike();
    }


    public function handleUnLike(): void
    {
        $this->serialLikeFacade->unLike($this->serial);
        $this->onDislike();
    }


    public function render(): void
    {
        $this->getTemplate()->liked = $this->serialLikeFacade->isLiked($this->serial);
        $this->getTemplate()->setFile(__DIR__ . "/templates/buttonLike.latte");
        $this->getTemplate()->render();
    }

}
