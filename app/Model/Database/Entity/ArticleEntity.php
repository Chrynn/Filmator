<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use App\Model\Enum\Admin\Content\Month\EDateMonth;
use App\Model\Enum\Admin\Content\Month\EMonthFacade;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "article")]
class ArticleEntity
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer", nullable: false)]
	protected int $id;

	#[ORM\Column(type: "string", nullable: false)]
	protected string $name;

	#[ORM\Column(type: "string", nullable: false)]
	protected string $slug;

	#[ORM\Column(type: "string", nullable: true)]
	protected ?string $description;

	#[ORM\Column(type: "string", nullable: false)]
	protected string $image;

	#[ORM\Column(type: "datetime", nullable: false)]
	protected DateTime $createdAt;

	/** @var Collection<int, UserEntity> */
	#[ORM\ManyToMany(targetEntity: UserEntity::class, mappedBy: "likeArticle")]
	#[ORM\JoinTable(name: "like_article")]
	protected Collection $likeUser;

	/** @var Collection<int, UserEntity> */
	#[ORM\ManyToMany(targetEntity: UserEntity::class, mappedBy: "laterArticle")]
	#[ORM\JoinTable(name: "later_article")]
	protected Collection $laterUser;

	/** @var Collection<int, ArticleLastEntity> */
	#[ORM\OneToMany(mappedBy: "article", targetEntity: ArticleLastEntity::class)]
	protected Collection $articleLast;


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
		$timeNow = new DateTime();
		$month = (int) $timeNow->format("m");

		return EDateMonth::tryFrom($month)->getMonth();
	}


	/** @return Collection<int, UserEntity> */
	public function getLikeUser(): Collection
	{
		return $this->likeUser;
	}


	/** @return Collection<int, UserEntity> */
	public function getLaterUser(): Collection
	{
		return $this->laterUser;
	}

}
