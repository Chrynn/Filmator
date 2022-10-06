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
#[Table(name: "movie")]
final class MovieEntity
{

	#[Id]
	#[GeneratedValue(strategy: "AUTO")]
	#[Column(type: "integer")]
	protected int $id;

	#[Column(type: "string", nullable: false)]
	protected string $slug;

	#[Column(type: "string", nullable: false)]
	protected string $name;

	#[Column(type: "smallint", nullable: false)]
	protected int $year;

	#[Column(type: "smallint", nullable: true)]
	protected ?int $rating;

	#[Column(type: "text", nullable: false)]
	protected string $teaser;

	#[Column(type: "text", nullable: false)]
	protected string $description;

	#[Column(type: "string", nullable: false)]
	protected string $imageBanner;

	#[Column(type: "string", nullable: false)]
	protected string $imagePoster;

	#[Column(type: "string", nullable: false)]
	protected string $trailer;

	/**
	 * @var Collection<int, UserEntity>
	 */
	#[ManyToMany(targetEntity: "UserEntity", mappedBy: "likeMovie")]
	#[JoinTable(name: "like_movie")]
	protected Collection $likeUser;

	/**
	 * @var Collection<int, UserEntity>
	 */
	#[ManyToMany(targetEntity: "UserEntity", mappedBy: "watchMovie")]
	#[JoinTable(name: "watch_movie")]
	protected Collection $watchUser;

	/**
	 * @var Collection<int, UserEntity>
	 */
	#[ManyToMany(targetEntity: "UserEntity", mappedBy: "tagMovie")]
	#[JoinTable(name: "tag_movie")]
	protected Collection $movieTag;


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


	public function getWatchUser(): Collection
	{
		return $this->watchUser;
	}


	/**
	 * @return Collection<int, TagWatchEntity>
	 */
	public function getMovieTag(): Collection
	{
		return $this->movieTag;
	}


	/**
	 * @param Collection<int, TagWatchEntity> $movieTag
	 */
	public function setMovieTag(Collection $movieTag): void
	{
		$this->movieTag = $movieTag;
	}

}
