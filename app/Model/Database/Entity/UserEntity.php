<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
final class UserEntity
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer", nullable=false)
	 */
	protected int $id;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $nickname;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $email;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $password;

	/**
	 * @ORM\Column(type="smallint", nullable=false)
	 */
	protected bool $conditions;

	/**
	 * @ORM\Column(type="smallint", nullable=false)
	 */
	protected bool $newsletter;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	protected string $role;

	/**
	 * @var Collection<int, MovieEntity>
	 * @ORM\ManyToMany(targetEntity="MovieEntity", inversedBy="likeUser")
	 * @ORM\JoinTable(name="like_movie")
	 */
	protected Collection $likeMovie;

	/**
	 * @var Collection<int, SerialEntity>
	 * @ORM\ManyToMany(targetEntity="SerialEntity", inversedBy="likeUser")
	 * @ORM\JoinTable(name="like_serial")
	 */
	protected Collection $likeSerial;

	/**
	 * @var Collection<int, ArticleEntity>
	 * @ORM\ManyToMany(targetEntity="ArticleEntity", inversedBy="likeUser")
	 * @ORM\JoinTable(name="like_article")
	 */
	protected Collection $likeArticle;

	/**
	 * @var Collection<int, ActorEntity>
	 * @ORM\ManyToMany(targetEntity="ActorEntity", inversedBy="likeUser")
	 * @ORM\JoinTable(name="like_actor")
	 */
	protected Collection $likeActor;

	/**
	 * @var Collection<int, MovieEntity>
	 * @ORM\ManyToMany(targetEntity="MovieEntity", inversedBy="laterUser")
	 * @ORM\JoinTable(name="later_movie")
	 */
	protected Collection $laterMovie;

	/**
	 * @var Collection<int, SerialEntity>
	 * @ORM\ManyToMany(targetEntity="SerialEntity", inversedBy="laterUser")
	 * @ORM\JoinTable(name="later_serial")
	 */
	protected Collection $laterSerial;

	/**
	 * @var Collection<int, ArticleEntity>
	 * @ORM\ManyToMany(targetEntity="ArticleEntity", inversedBy="laterUser")
	 * @ORM\JoinTable(name="later_article")
	 */
	protected Collection $laterArticle;


	public function __construct()
	{
		$this->likedMovies = new ArrayCollection();
	}


	public function getId(): int
	{
		return $this->id;
	}


	public function getNickname(): string
	{
		return $this->nickname;
	}


	public function setNickname(string $nickname): void
	{
		$this->nickname = $nickname;
	}


	public function getEmail(): string
	{
		return $this->email;
	}


	public function setEmail(string $email): void
	{
		$this->email = $email;
	}


	public function getPassword(): string
	{
		return $this->password;
	}


	public function setPassword(string $password): void
	{
		$this->password = $password;
	}


	public function setConditions(bool $conditions): void
	{
		$this->conditions = $conditions;
	}


	public function getNewsletter(): bool
	{
		return $this->newsletter;
	}


	public function setNewsletter(bool $newsletter): void
	{
		$this->newsletter = $newsletter;
	}


	public function getRole(): string
	{
		return $this->role;
	}


	public function setRole(string $role): void
	{
		$this->role = $role;
	}


	/**
	 * @return Collection<int, MovieEntity>
	 */
	public function getLikeMovie(): Collection
	{
		return $this->likeMovie;
	}


	/**
	 * @return Collection<int, SerialEntity>
	 */
	public function getLikeSerial(): Collection
	{
		return $this->likeSerial;
	}


	/**
	 * @return Collection<int, ActorEntity>
	 */
	public function getLikeActor(): Collection
	{
		return $this->likeActor;
	}


	/**
	 * @return Collection<int, ArticleEntity>
	 */
	public function getLikeArticle(): Collection
	{
		return $this->likeArticle;
	}


	public function getLaterMovie(): Collection
	{
		return $this->laterMovie;
	}


	public function setLaterMovie(Collection $laterMovie): void
	{
		$this->laterMovie = $laterMovie;
	}


	public function getLaterSerial(): Collection
	{
		return $this->laterSerial;
	}


	public function getLaterArticle(): Collection
	{
		return $this->laterArticle;
	}


	public function setLaterArticle(Collection $laterArticle): void
	{
		$this->laterArticle = $laterArticle;
	}

}
