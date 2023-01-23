<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use App\Model\Enum\Admin\Content\Month\EDateMonth;
use DateTime;
use App\Model\Trait\hasCreatedAt;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Strings;

#[ORM\Entity]
#[ORM\Table(name: "article")]
class ArticleEntity extends AbstractListEntity
{

	use hasCreatedAt;


	private const IMAGE_PATH = "img/fixture/article/";


	#[ORM\Column(type: "string", nullable: false)]
	protected string $name;

	#[ORM\Column(type: "string", nullable: false)]
	protected string $slug;

	#[ORM\Column(type: "string", nullable: true)]
	protected ?string $description;

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


	public function __construct(string $name)
	{
		$this->name = $name;
		$this->slug = Strings::webalize($name);
		$this->createdAt = new DateTime();
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getSlug(): string
	{
		return $this->slug;
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
		return self::IMAGE_PATH . $this->getId() . "/" . $this->getId();
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
