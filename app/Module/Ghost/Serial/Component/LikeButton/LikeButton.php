<?php declare(strict_types=1);

namespace App\Module\Ghost\Serial\Component\LikeButton;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\LikeButton\LikeSerialFacade;
use Nette\Application\UI\Control;

class LikeButton extends Control
{
    private SerialEntity $serial;

    public array $onLike;
    public array $onDislike;
	private LikeSerialFacade $likeSerialFacade;

	public function __construct(SerialEntity $serial, LikeSerialFacade $likeSerialFacade)
    {
        $this->serial = $serial;
		$this->likeSerialFacade = $likeSerialFacade;
	}

    public function handleLike(): void
    {
        $this->likeSerialFacade->like($this->serial);
        $this->onLike();
    }

    public function handleDislike(): void
    {
        $this->likeSerialFacade->dislike($this->serial);
        $this->onDislike();
    }

    public function render(): void
    {
        $this->getTemplate()->liked = $this->likeSerialFacade->isLiked($this->serial);
        $this->getTemplate()->setFile(__DIR__ . "/templates/likeButton.latte");
        $this->getTemplate()->render();
    }
}