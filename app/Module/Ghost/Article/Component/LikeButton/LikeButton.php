<?php declare(strict_types = 1);

namespace App\Module\Ghost\Article\Component\LikeButton;

use App\Model\Database\Entity\ArticleEntity;
use App\Model\Facade\LikeButton\LikeArticleFacade;
use Nette\Application\UI\Control;

class LikeButton extends Control
{

	public array $onLike;
	public array $onDislike;

	private ArticleEntity $article;
	private LikeArticleFacade $likeArticleFacade;

	public function __construct(ArticleEntity $article, LikeArticleFacade $likeArticleFacade)
	{
		$this->article = $article;
		$this->likeArticleFacade = $likeArticleFacade;
	}

	public function handleLike(): void
	{
		$this->likeArticleFacade->like($this->article);
		$this->onLike();
	}

	public function handleDislike(): void
	{
		$this->likeArticleFacade->dislike($this->article);
		$this->onDislike();
	}

	public function render(): void
	{
		$this->getTemplate()->liked = $this->likeArticleFacade->isLiked($this->article);
		$this->getTemplate()->setFile(__DIR__ . "/templates/likeButton.latte");
		$this->getTemplate()->render();
	}

}
