<?php declare(strict_types = 1);

namespace App\Module\Front\Article\components\ButtonLater;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\User\ButtonLater\LaterArticleFacade;
use Nette\Application\UI\Control;

class ButtonLater extends Control
{

	public array $onLater;
	public array $onUnLater;


	public function __construct(
		private readonly ArticleEntity $article,
		private readonly LaterArticleFacade $laterArticleFacade
	) {}


	public function handleLater(): void
	{
		$this->laterArticleFacade->later($this->article);
		$this->onLater();
	}


	public function handleUnLater(): void
	{
		$this->laterArticleFacade->unLater($this->article);
		$this->onUnLater();
	}


	public function render(): void
	{
		$this->getTemplate()->later = $this->laterArticleFacade->laterMarked($this->article);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLater.latte");
		$this->getTemplate()->render();
	}

}
