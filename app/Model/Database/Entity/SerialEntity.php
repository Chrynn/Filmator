<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use App\Model\Facade\Admin\Content\Image\ImageFacade;
use DateTime;
use App\Model\Trait\hasCreatedAt;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Strings;

#[ORM\Entity]
#[ORM\Table(name: "serial")]
class SerialEntity extends AbstractListEntity
{

	use hasCreatedAt;


	private const IMAGE_PATH = "img/fixture/serial/";


	#[ORM\Column(type: "string", nullable: false)]
	protected string $slug;

	#[ORM\Column(type: "string")]
	protected string $name;

	#[ORM\Column(type: "string", nullable: false)]
	protected string $year;

	#[ORM\Column(type: "smallint", nullable: true)]
	protected ?int $rating;

	#[ORM\Column(type: "text", nullable: false)]
	protected string $teaser;

	#[ORM\Column(type: "text", nullable: false)]
	protected string $description;

	#[ORM\Column(type: "text", nullable: false)]
	protected string $trailer;

	/** @var Collection<int, UserEntity> */
	#[ORM\ManyToMany(targetEntity: UserEntity::class, mappedBy: "likeSerial")]
	#[ORM\JoinTable(name: "serial_like")]
	protected Collection $likeUser;

	/** @var Collection<int, UserEntity> */
	#[ORM\ManyToMany(targetEntity: UserEntity::class, mappedBy: "laterSerial")]
	#[ORM\JoinTable(name: "serial_later")]
	protected Collection $laterUser;

	/** @var Collection<int, SerialLastEntity> */
	#[ORM\OneToMany(mappedBy: "serial", targetEntity: SerialLastEntity::class)]
	protected Collection $serialLast;


	public function __construct(string $name)
	{
		$this->name = $name;
		$this->slug = Strings::webalize($name);
		$this->createdAt = new DateTime();
	}


	public function getSlug(): string
	{
		return $this->slug;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getYear(): string
	{
		return $this->year;
	}


	public function setYear(string $year): void
	{
		$this->year = $year;
	}


	public function getRating(): ?int
	{
		return $this->rating;
	}


	public function setRating(?int $rating): void
	{
		$this->rating = $rating;
	}


	public function getTeaser(): string
	{
		return $this->teaser;
	}


	public function setTeaser(string $teaser): void
	{
		$this->teaser = $teaser;
	}


	public function getDescription(): ?string
	{
		return $this->description;
	}


	public function setDescription(?string $description): void
	{
		$this->description = $description;
	}


	public function getImagePoster(): string
	{
		return self::IMAGE_PATH . $this->getId() . "/" . $this->getId() . "_"  . ImageFacade::IMAGE_TYPE_POSTER;
	}


	public function getImageBanner(): string
	{
		return self::IMAGE_PATH . $this->getId() . "/" . $this->getId() . "_" . ImageFacade::IMAGE_TYPE_BANNER;
	}


	public function getTrailer(): string
	{
		return $this->trailer;
	}


	public function setTrailer(string $trailer): void
	{
		$this->trailer = $trailer;
	}


	/**
	 * @return Collection<int, UserEntity>
	 */
	public function getLikeUser(): Collection
	{
		return $this->likeUser;
	}


	public function getLaterUser(): Collection
	{
		return $this->laterUser;
	}


	public function setLaterUser(Collection $laterUser): void
	{
		$this->laterUser = $laterUser;
	}

}
