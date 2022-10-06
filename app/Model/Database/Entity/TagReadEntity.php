<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "read_tag")]
final class TagReadEntity
{

	#[Id]
	#[GeneratedValue(strategy: "AUTO")]
	#[Column(type: "integer")]
	protected int $id;

	#[Column(type: "string", nullable: false)]
	protected string $title;

	/**
	 * @var Collection<int, ArticleEntity>
	 */
	#[ManyToMany(targetEntity: "ArticleEntity", inversedBy: "articleTag")]
	#[JoinTable(name: "tag_article")]
	protected Collection $tagArticle;


	public function getId(): int
	{
		return $this->id;
	}


	public function getTitle(): string
	{
		return $this->title;
	}


	public function setTitle(string $title): void
	{
		$this->title = $title;
	}


	/**
	 * @return Collection<int, ArticleEntity>
	 */
	public function getTagArticle(): Collection
	{
		return $this->tagArticle;
	}


	/**
	 * @param Collection<int, ArticleEntity> $tagArticle
	 */
	public function setTagArticle(Collection $tagArticle): void
	{
		$this->tagArticle = $tagArticle;
	}

}
