<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "article")]
final class ArticleEntity
{

	#[Id]
	#[GeneratedValue(strategy: "AUTO")]
	#[Column(type: "integer")]
	protected int $id;

	#[Column(type: "string", nullable: false)]
	protected string $name;

	#[Column(type: "string", nullable: false)]
	protected string $slug;

	#[Column(type: "string", nullable: true)]
	protected ?string $description;

	#[Column(type: "string", nullable: false)]
	protected string $image;

	#[Column(type: "datetime", nullable: false)]
	protected DateTime $createdAt;

	#[Column(type: "string", nullable: false)]
	protected string $createdAtMonth;

	/**
	 * @var Collection<int, UserEntity>
	 */
	#[ManyToMany(targetEntity: "UserEntity", mappedBy: "likeArticle")]
	#[JoinTable(name: "like_article")]
	protected Collection $likeUser;

	/**
	 * @var Collection<int, UserEntity>
	 */
	#[ManyToMany(targetEntity: "UserEntity", mappedBy: "watchArticle")]
	#[JoinTable(name: "read_article")]
	protected Collection $watchUser;

	/**
	 * @var Collection<int, TagReadEntity>
	 */
	#[ManyToMany(targetEntity: "TagReadEntity", mappedBy: "tagArticle")]
	#[JoinTable(name: "tag_article")]
	protected Collection $articleTag;


	public function getId(): int
	{
		return $this->id;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function setName(string $name): void
	{
		$this->name = $name;
	}


	public function getSlug(): string
	{
		return $this->slug;
	}


	public function setSlug(string $slug): void
	{
		$this->slug = $slug;
	}


	public function getDescription(): ?string
	{
		return $this->description;
	}


	public function setDescription(?string $description): void
	{
		$this->description = $description;
	}


	/**
	 * @return Collection<int, UserEntity>
	 */
	public function getLikeUser(): Collection
	{
		return $this->likeUser;
	}


	/**
	 * @return Collection<int, UserEntity>
	 */
	public function getWatchUser(): Collection
	{
		return $this->watchUser;
	}


	/**
	 * @return Collection<int, TagReadEntity>
	 */
	public function getArticleTag(): Collection
	{
		return $this->articleTag;
	}


	/**
	 * @param Collection<int, TagReadEntity> $articleTag
	 */
	public function setArticleTag(Collection $articleTag): void
	{
		$this->articleTag = $articleTag;
	}


	public function getImage(): string
	{
		return $this->image;
	}


	public function setImage(string $image): void
	{
		$this->image = $image;
	}


	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}


	public function setCreatedAt(DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}


	public function getCreatedAtMonth(): string
	{
		return $this->createdAtMonth;
	}


	public function setCreatedAtMonth(string $createdAtMonth): void
	{
		$this->createdAtMonth = $createdAtMonth;
	}

}
