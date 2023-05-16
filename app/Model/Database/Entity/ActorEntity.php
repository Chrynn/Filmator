<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use DateTime;
use App\Model\Trait\hasCreatedAt;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Strings;

#[ORM\Entity]
#[ORM\Table(name: "actor")]
class ActorEntity extends AbstractListEntity
{

	use hasCreatedAt;


	private const IMAGE_PATH = "img/fixture/actor/";


	#[ORM\Column(type: "string", nullable: false)]
	protected string $slug;

	#[ORM\Column(type: "string", nullable: false)]
	protected string $name;

	/** @var Collection<int, UserEntity> */
	#[ORM\ManyToMany(targetEntity: UserEntity::class, mappedBy: "likeActor")]
	#[ORM\JoinTable(name: "like_actor")]
	protected Collection $likeUser;


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


	public function getImagePoster(): string
	{
		return self::IMAGE_PATH . $this->getId() . "/" . $this->getId() . self::POSTER_PREFIX;
	}


	public function getImageBanner(): string
	{
		return self::IMAGE_PATH . $this->getId() . "/" . $this->getId() . self::BANNER_PREFIX;
	}


	/** @return Collection<int, UserEntity> */
	public function getLikeUser(): Collection
	{
		return $this->likeUser;
	}

}
