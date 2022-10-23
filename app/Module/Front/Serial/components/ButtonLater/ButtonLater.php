<?php declare(strict_types = 1);

namespace App\Module\Front\Serial\components\ButtonLater;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\User\ButtonLater\LaterSerialFacade;
use Nette\Application\UI\Control;

class ButtonLater extends Control
{

	public array $onLater;
	public array $onUnLater;


	public function __construct(
		private readonly SerialEntity $serial,
		private readonly LaterSerialFacade $laterSerialFacade
	) {}


	public function handleLater(): void
	{
		$this->laterSerialFacade->later($this->serial);
		$this->onLater();
	}


	public function handleUnLater(): void
	{
		$this->laterSerialFacade->unLater($this->serial);
		$this->onUnLater();
	}


	public function render(): void
	{
		$this->getTemplate()->later = $this->laterSerialFacade->laterMarked($this->serial);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLater.latte");
		$this->getTemplate()->render();
	}

}
