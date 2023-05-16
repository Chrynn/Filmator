<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use App\Model\Facade\Admin\Content\Image\ImageFacade;
use App\Model\Trait\hasCreatedAt;
use App\Model\Trait\hasEditedAt;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Strings;

#[ORM\Entity]
#[ORM\Table(name: "movie")]
class MovieEntity extends AbstractListEntity
{

	use hasCreatedAt;
	use hasEditedAt;


	#[ORM\Column(type: "string", nullable: false)]
	protected string $slug;

	#[ORM\Column(type: "string", nullable: false)]
	protected string $name;

	#[ORM\Column(type: "smallint", nullable: false)]
	protected int $year;

	#[ORM\Column(type: "smallint", nullable: true)]
	protected ?int $rating;

	#[ORM\Column(type: "text", nullable: false)]
	protected string $teaser;

	#[ORM\Column(type: "text", nullable: false)]
	protected string $description;

	#[ORM\Column(type: "string", nullable: false)]
	protected string $trailer;

	/** @var Collection<int, UserEntity> */
	#[ORM\ManyToMany(targetEntity: UserEntity::class, mappedBy: "likeMovie")]
	#[ORM\JoinTable(name: "movie_like")]
	protected Collection $likeUser;

	/** @var Collection<int, UserEntity> */
	#[ORM\ManyToMany(targetEntity: UserEntity::class, mappedBy: "laterMovie")]
	#[ORM\JoinTable(name: "movie_later")]
	protected Collection $laterUser;

	/** @var Collection<int, MovieLastEntity> */
	#[ORM\OneToMany(mappedBy: "movie", targetEntity: MovieLastEntity::class)]
    protected Collection $movieLast;


	public function __construct(string $name)
	{
		$timeNow = new DateTime();

		$this->name = $name;
		$this->slug = Strings::webalize($name);
		$this->createdAt = $timeNow;
		$this->editedAt = $timeNow;
	}


	public function getSlug(): string
	{
		return $this->slug;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getYear(): int
	{
		return $this->year;
	}


	public function setYear(int $year): void
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


	public function getDescription(): string
	{
		return $this->description;
	}


	public function setDescription(string $description): void
	{
		$this->description = $description;
	}


	public function getImagePoster(): string
	{
		return "img/public/movie/" . $this->getId() . "/" . $this->getId() . "_" . ImageFacade::IMAGE_TYPE_POSTER;
	}


	public function getImageBanner(): string
	{
		return "img/public/movie/" . $this->getId() . "/" . $this->getId() . "_" . ImageFacade::IMAGE_TYPE_BANNER;
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

    /**
     * @return Collection<int, MovieEntity>
     */
    public function getMovieLast(): Collection
    {
        return $this->movieLast;
    }

    /**
     * @param Collection $movieLast
     */
    public function setMovieLast(Collection $movieLast): void
    {
        $this->movieLast = $movieLast;
    }

}
