<?php declare(strict_types = 1);

namespace App\Module\Anonymous\Article\components\ButtonLater;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\User\ButtonLater\LaterArticleFacade;
use Nette\Application\UI\Control;

class ButtonLater extends Control
{

	public array $onWatch;
	public array $onUnWatch;


	public function __construct(
		private readonly ArticleEntity $article,
		private readonly LaterArticleFacade $laterArticleFacade
	) {}


	public function handleWatch(): void
	{
		$this->laterArticleFacade->watch($this->article);
		$this->onWatch();
	}


	public function handleUnWatch(): void
	{
		$this->laterArticleFacade->unWatch($this->article);
		$this->onUnWatch();
	}


	public function render(): void
	{
		$this->getTemplate()->wantWatch = $this->laterArticleFacade->wantWatch($this->article);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLate.latte");
		$this->getTemplate()->render();
	}

}
