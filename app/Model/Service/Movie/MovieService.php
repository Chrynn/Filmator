<?php declare(strict_types = 1);

namespace App\Model\Service\Movie;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\Front\Auth\UserIdentityFacade;
use Doctrine\ORM\EntityManagerInterface;

final class MovieService implements IMovieService
{

	public function __construct(
		private readonly EntityManagerInterface $entityManager
	) {}


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

}
