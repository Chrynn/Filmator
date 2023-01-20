<?php declare(strict_types = 1);

namespace App\Module\Front\Article\components\ButtonLike;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\User\Like\ArticleLikeFacade;
use Nette\Application\UI\Control;

class ButtonLike extends Control
{

	public array $onMarkLike;
	public array $onUnmarkLike;


	public function __construct(
		private readonly ArticleEntity $article,
		private readonly ArticleLikeFacade $articleLikeFacade
	) {}


	public function handleMarkLike(): void
	{
		$this->articleLikeFacade->markLike($this->article);
		$this->onMarkLike();
	}


	public function handleUnmarkLike(): void
	{
		$this->articleLikeFacade->unmarkLike($this->article);
		$this->onUnmarkLike();
	}


	public function render(): void
	{
		$this->getTemplate()->liked = $this->articleLikeFacade->isMarkedLike($this->article);

		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLike.latte");
		$this->getTemplate()->render();
	}

}
