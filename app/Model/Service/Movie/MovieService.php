<?php declare(strict_types = 1);

namespace App\Model\Service\Movie;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Database\Entity\UserEntity;
use App\Model\Facade\Admin\Content\Image\ImageFacade;
use App\Model\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;

final class MovieService extends AbstractService implements IMovieService
{

	public function __construct(
		protected EntityManagerInterface $entityManager,
		private readonly ImageFacade $imageFacade
	) {
		parent::__construct($entityManager);
	}


	public function getMovies(): array
	{
		return $this->entityManager->getRepository(MovieEntity::class)->findAll();
	}


	public function getMoviesByOrder(string $order): array
	{
		return $this->entityManager->createQueryBuilder()
			->select("movie")
			->from(MovieEntity::class, "movie")
			->orderBy("movie.id", $order)
			->getQuery()
			->getArrayResult();
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


	public function getMoviesLastByUser(UserEntity $user): array
	{
		return $this->entityManager->createQueryBuilder()
			->select("movie, movieLast, user")
			->from(MovieEntity::class, "movie")
			->join("movie.movieLast", "movieLast")
			->join("movieLast.user", "user")
			->where("user.id = :userId")
			->setParameter("userId", $user->getId())
			->orderBy("movieLast.createdAt", "DESC")
			->getQuery()
			->getResult();
	}


	public function save(array $values): ?MovieEntity
	{
		$movie = new MovieEntity(
			$values["name"]
		);
		$movie->setYear($values["year"]);
		$movie->setRating($values["rating"]);
		$movie->setTrailer($values["trailer"]);
		$movie->setDescription($values["description"]);
		$movie->setTeaser($values["teaser"]);

		$this->entityManager->wrapInTransaction(function () use ($movie, $values) {
			$this->saveEntity($movie);

			$movieId = $movie->getId();
			$this->imageFacade->createImageFromUpload($values["banner"], $movieId, ImageFacade::CONTENT_TYPE_MOVIE, ImageFacade::IMAGE_TYPE_BANNER);
			$this->imageFacade->createImageFromUpload($values["poster"], $movieId, ImageFacade::CONTENT_TYPE_MOVIE, ImageFacade::IMAGE_TYPE_POSTER);
		});

		return $movie;
	}

	public function findMovieById(int $id): ?MovieEntity
	{
		return $this->entityManager->find(MovieEntity::class, $id);
	}

}
