<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "movie")]
final class MovieEntity
{

	#[ORM\Id]
	#[ORM\GeneratedValue(strategy: "AUTO")]
	#[ORM\Column(type: "integer", nullable: false)]
	protected int $id;

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
	protected string $imageBanner;

	#[ORM\Column(type: "string", nullable: false)]
	protected string $imagePoster;

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


	public function getId(): int
	{
		return $this->id;
	}


	public function getSlug(): string
	{
		return $this->slug;
	}


	public function setSlug(string $slug): void
	{
		$this->slug = $slug;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function setName(string $name): void
	{
		$this->name = $name;
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
		return $this->imagePoster;
	}


	public function setImagePoster(string $imagePoster): void
	{
		$this->imagePoster = $imagePoster;
	}


	public function getImageBanner(): string
	{
		return $this->imageBanner;
	}


	public function setImageBanner(string $imageBanner): void
	{
		$this->imageBanner = $imageBanner;
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
