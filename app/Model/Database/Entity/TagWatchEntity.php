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
#[Table(name: "watch_tag")]
final class TagWatchEntity
{

	#[Id]
	#[GeneratedValue(strategy: "AUTO")]
	#[Column(type: "integer")]
	protected int $id;

	#[Column(type: "string", nullable: false)]
	protected string $title;

	/**
	 * @var Collection<int, MovieEntity>
	 */
	#[ManyToMany(targetEntity: "MovieEntity", inversedBy: "movieTag")]
	#[JoinTable(name: "tag_movie")]
	protected Collection $tagMovie;

	/**
	 * @var Collection<int, SerialEntity>
	 */
	#[ManyToMany(targetEntity: "SerialEntity", inversedBy: "serialTag")]
	#[JoinTable(name: "tag_serial")]
	protected Collection $tagSerial;


	public function getId(): int
	{
		return $this->id;
	}


	public function getTitle(): string
	{
		return $this->title;
	}


	public function setTitle(string $title): void
	{
		$this->title = $title;
	}


	/**
	 * @return Collection<int, MovieEntity>
	 */
	public function getTagMovie(): Collection
	{
		return $this->tagMovie;
	}


	/**
	 * @param Collection<int, MovieEntity> $tagMovie
	 */
	public function setTagMovie(Collection $tagMovie): void
	{
		$this->tagMovie = $tagMovie;
	}


	/**
	 * @return Collection<int, SerialEntity>
	 */
	public function getTagSerial(): Collection
	{
		return $this->tagSerial;
	}


	/**
	 * @param Collection<int, SerialEntity> $tagSerial
	 */
	public function setTagSerial(Collection $tagSerial): void
	{
		$this->tagSerial = $tagSerial;
	}

}
