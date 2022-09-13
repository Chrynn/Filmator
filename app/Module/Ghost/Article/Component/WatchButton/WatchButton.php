<?php declare(strict_types = 1);

namespace App\Module\Ghost\Article\Component\WatchButton;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\WatchButton\WatchArticleFacade;
use Nette\Application\UI\Control;

class WatchButton extends Control
{

	public array $onWatch;
	public array $onUnWatch;

	private ArticleEntity $article;
	private WatchArticleFacade $watchArticleFacade;

	public function __construct(
		ArticleEntity $article,
		WatchArticleFacade $watchArticleFacade,
	)
	{
		$this->article = $article;
		$this->watchArticleFacade = $watchArticleFacade;
	}

	public function handleWatch(): void
	{
		$this->watchArticleFacade->watch($this->article);
		$this->onWatch();
	}

	public function handleUnWatch(): void
	{
		$this->watchArticleFacade->unWatch($this->article);
		$this->onUnWatch();
	}

	public function render(): void
	{
		$this->getTemplate()->wantWatch = $this->watchArticleFacade->wantWatch($this->article);
		$this->getTemplate()->setFile(__DIR__ . "/templates/watchButton.latte");
		$this->getTemplate()->render();
	}

}
