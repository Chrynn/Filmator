<?php

declare(strict_types=1);

namespace App\Model\Database\Entity;

use DateTime;
use App\Model\Trait\hasCreatedAt;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "article_last")]
class ArticleLastEntity extends AbstractListEntity
{

	use hasCreatedAt;


	#[ORM\ManyToOne(targetEntity: UserEntity::class, inversedBy: "userArticleLast")]
	protected UserEntity $user;

	#[ORM\ManyToOne(targetEntity: ArticleEntity::class, inversedBy: "articleLast")]
	protected ArticleEntity $article;


	public function __construct()
	{
		$this->createdAt = new DateTime();
	}


	public function getUser(): UserEntity
	{
		return $this->user;
	}

	public function setUser(UserEntity $user): void
	{
		$this->user = $user;
	}

	public function getArticle(): ArticleEntity
	{
		return $this->article;
	}

	public function setArticle(ArticleEntity $article): void
	{
		$this->article = $article;
	}

}