<?php declare(strict_types = 1);

namespace App\Module\Ghost\Serial\Component\WatchButton;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\WatchButton\WatchSerialFacade;
use Nette\Application\UI\Control;

class WatchButton extends Control
{

	public array $onWatch;
	public array $onUnWatch;

	private SerialEntity $serial;
	private WatchSerialFacade $watchSerialFacade;

	public function __construct(
		SerialEntity $serial,
		WatchSerialFacade $watchSerialFacade,
	)
	{
		$this->serial = $serial;
		$this->watchSerialFacade = $watchSerialFacade;
	}

	public function handleWatch(): void
	{
		$this->watchSerialFacade->watch($this->serial);
		$this->onWatch();
	}

	public function handleUnWatch(): void
	{
		$this->watchSerialFacade->unWatch($this->serial);
		$this->onUnWatch();
	}

	public function render(): void
	{
		$this->getTemplate()->wantWatch = $this->watchSerialFacade->wantWatch($this->serial);
		$this->getTemplate()->setFile(__DIR__ . "/templates/watchButton.latte");
		$this->getTemplate()->render();
	}

}
