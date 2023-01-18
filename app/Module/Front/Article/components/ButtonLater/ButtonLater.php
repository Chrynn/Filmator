<?php declare(strict_types = 1);

namespace App\Module\Front\Article\components\ButtonLater;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\User\Later\LaterArticleFacade;
use Nette\Application\UI\Control;

class ButtonLater extends Control
{

	public array $onMarkLater;
	public array $onUnmarkLater;


	public function __construct(
		private readonly ArticleEntity $article,
		private readonly LaterArticleFacade $laterArticleFacade
	) {}


	public function handleMarkLater(): void
	{
		$this->laterArticleFacade->markLater($this->article);
		$this->onMarkLater();
	}


	public function handleUnmarkLater(): void
	{
		$this->laterArticleFacade->unmarkLater($this->article);
		$this->onUnmarkLater();
	}


	public function render(): void
	{
		$this->getTemplate()->later = $this->laterArticleFacade->isMarkedLater($this->article);

		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLater.latte");
		$this->getTemplate()->render();
	}

}
