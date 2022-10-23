<?php declare(strict_types = 1);

namespace App\Module\Front\Article\components\ButtonLike;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\User\Like\ArticleLikeFacade;
use Nette\Application\UI\Control;

class ButtonLike extends Control
{

	public array $onLike;
	public array $onDislike;


	public function __construct(
		private readonly ArticleEntity $article,
		private readonly ArticleLikeFacade $articleLikeFacade
	) {}


	public function handleLike(): void
	{
		$this->articleLikeFacade->like($this->article);
		$this->onLike();
	}


	public function handleUnLike(): void
	{
		$this->articleLikeFacade->unLike($this->article);
		$this->onDislike();
	}


	public function render(): void
	{
		$this->getTemplate()->liked = $this->articleLikeFacade->isLiked($this->article);
		$this->getTemplate()->setFile(__DIR__ . "/templates/buttonLike.latte");
		$this->getTemplate()->render();
	}

}
