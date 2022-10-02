<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="actor")
 */
class ActorEntity
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected int $id;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $slug;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $name;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $imagePoster;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $imageBanner;

	/**
	 * @var Collection<int, UserEntity>
	 * @ORM\ManyToMany(targetEntity="UserEntity", mappedBy="likeActor")
	 * @ORM\JoinTable(name="like_actor")
	 */
	protected Collection $likeUser;


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


	/**
	 * @return Collection<int, UserEntity>
	 */
	public function getLikeUser(): Collection
	{
		return $this->likeUser;
	}

}
