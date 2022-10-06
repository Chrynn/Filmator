<?php declare(strict_types = 1);

namespace App\Model\Service\Movie;

use App\Model\Database\Entity\MovieEntity;

interface IMovieService
{

	public function getMovies(): array;

	public function getMovieBySlug(string $slug): MovieEntity;

	public function getMoviesByLimit(int $limit): array;

}
