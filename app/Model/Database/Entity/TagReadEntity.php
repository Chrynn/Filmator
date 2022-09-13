<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="read_tag")
 */
class TagReadEntity
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected int $id;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $title;

	/**
	 * @var Collection<int, ArticleEntity>
	 * @ORM\ManyToMany(targetEntity="ArticleEntity", inversedBy="articleTag")
	 * @ORM\JoinTable(name="tag_article")
	 */
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
