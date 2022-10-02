<?php declare(strict_types = 1);

namespace App\Model\Service\Movie;

use App\Model\Database\Entity\MovieEntity;
use Doctrine\ORM\EntityManagerInterface;

final class MovieService
{

	private EntityManagerInterface $entityManager;


	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	public function getMovies(): array
	{
		return $this->entityManager->getRepository(MovieEntity::class)->findAll();
	}


	public function getMovieBySlug(string $slug): MovieEntity
	{
		return $this->entityManager->getRepository(MovieEntity::class)->findOneBy([
			"slug" => $slug,
		]);
	}


	public function getMoviesByLimit(int $limit): array
	{
		return $this->entityManager->getRepository(MovieEntity::class)->findBy([], null, $limit, 0);
	}


	public function getMoviesByTrend(int $limit): array
	{
		// vytáhnutí filmu (movie) podle roku (nejnovější)
		/*
		return $this->entityManager->createQueryBuilder()
			->select()
			->from()
			->where()
			->setParameter()
			->getQuery()
			->getSingleScalarResult();
		*/
		return [];
	}

}
