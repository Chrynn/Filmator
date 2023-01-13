<?php declare(strict_types = 1);

namespace App\Module\Front\Serial\components\ButtonLater;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\User\Later\LaterSerialFacade;
use Nette\Application\UI\Control;

class ButtonLater extends Control
{

	public array $onMarkLater;
	public array $onUnmarkLater;


	public function __construct(
		private readonly SerialEntity $serial,
		private readonly LaterSerialFacade $laterSerialFacade
	) {}


	public function handleMarkLater(): void
	{
		$this->laterSerialFacade->markLater($this->serial);
		$this->onMarkLater();
	}


	public function handleUnmarkLater(): void
	{
		$this->laterSerialFacade->unmarkLater($this->serial);
		$this->onUnmarkLater();
	}


	public function render(): void
	{
		$this->getTemplate()->later = $this->laterSerialFacade->isMarkedLater($this->serial);

		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLater.latte");
		$this->getTemplate()->render();
	}

}
