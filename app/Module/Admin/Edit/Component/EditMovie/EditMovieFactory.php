<?php declare(strict_types = 1);

namespace App\Module\Admin\Edit\Component\EditMovie;

use App\Model\Database\Entity\MovieEntity;

interface EditMovieFactory
{

	public function create(MovieEntity $movie): EditMovie;

}
