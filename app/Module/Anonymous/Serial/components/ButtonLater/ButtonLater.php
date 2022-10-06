<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Serial\components\ButtonLater;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\User\ButtonLater\LaterSerialFacade;
use Nette\Application\UI\Control;

class ButtonLater extends Control
{

	public array $onWatch;
	public array $onUnWatch;


	public function __construct(
		private readonly SerialEntity $serial,
		private readonly LaterSerialFacade $laterSerialFacade
	) {}


	public function handleWatch(): void
	{
		$this->laterSerialFacade->watch($this->serial);
		$this->onWatch();
	}


	public function handleUnWatch(): void
	{
		$this->laterSerialFacade->unWatch($this->serial);
		$this->onUnWatch();
	}


	public function render(): void
	{
		$this->getTemplate()->wantWatch = $this->laterSerialFacade->wantWatch($this->serial);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLater.latte");
		$this->getTemplate()->render();
	}

}
