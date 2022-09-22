<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Security\User;
use Nette\Utils\DateTime;


/**
 * @ORM\Entity
 * @ORM\Table(name="article")
 */
class ArticleEntity
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
	protected string $name;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $slug;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected ?string $description;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $image;

	/**
	 * @ORM\Column(type="datetime", nullable=false)
	 */
	protected \DateTime $createdAt;

	/**
	 * @var Collection<int, UserEntity>
	 * @ORM\ManyToMany(targetEntity="UserEntity", mappedBy="likeArticle")
	 * @ORM\JoinTable(name="like_article")
	 */
	protected Collection $likeUser;

	/**
	 * @var Collection<int, UserEntity>
	 * @ORM\ManyToMany(targetEntity="UserEntity", mappedBy="watchArticle")
	 * @ORM\JoinTable(name="read_article")
	 */
	protected Collection $watchUser;

	/**
	 * @var Collection<int, TagReadEntity>
	 * @ORM\ManyToMany(targetEntity="TagReadEntity", mappedBy="tagArticle")
	 * @ORM\JoinTable(name="tag_article")
	 */
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


	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}


	public function setCreatedAt(\DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}

}
