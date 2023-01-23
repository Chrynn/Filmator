<?php

declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Trait\hasCreatedAt;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "movie_last")]
class MovieLastEntity extends AbstractListEntity
{

	use hasCreatedAt;


	#[ORM\ManyToMany(targetEntity: UserEntity::class, inversedBy: "userMovieLast")]
	protected UserEntity $user;

	#[ORM\ManyToOne(targetEntity: MovieEntity::class, inversedBy: "movieLast")]
	protected MovieEntity $movie;


	public function __construct()
	{
		$this->createdAt = new DateTime();
	}


	public function getUser(): UserEntity
	{
		return $this->user;
	}

	public function setUser(UserEntity $user): void
	{
		$this->user = $user;
	}

	public function getMovie(): MovieEntity
	{
		return $this->movie;
	}

	public function setMovie(MovieEntity $movie): void
	{
		$this->movie = $movie;
	}

}