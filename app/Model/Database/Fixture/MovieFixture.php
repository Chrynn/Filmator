<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Admin\Content\Trailer\TrailerFacade;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Utils\Strings;
use Nettrine\Fixtures\ContainerAwareInterface;

final class MovieFixture extends AbstractFixture implements ContainerAwareInterface
{

	public function getTrailerFacade(): TrailerFacade
	{
		return $this->getContainer()->getByType(TrailerFacade::class);
	}


	public function load(ObjectManager $manager): void
	{
		$movies = Neon::decodeFile(__DIR__ . "/content/movie.neon");

		foreach ($movies as $movie) {
			$newMovie = new MovieEntity();
			$title = $movie['title'];
			$newMovie->setName($title);
			$newMovie->setSlug(Strings::webalize($title));
			$newMovie->setYear($movie['year']);
			$newMovie->setRating($movie['rating']);
			$newMovie->setTeaser($movie['teaser']);
			$newMovie->setDescription($movie['description']);
			foreach ($movie['image'] as $type => $value) {
				if ($type === 'imageBanner') {
					$newMovie->setImageBanner($value);
				}
				if ($type === 'imagePoster') {
					$newMovie->setImagePoster($value);
				}
			}
			$newMovie->setTrailer($this->getTrailerFacade()->getTrailerLink($movie['trailer']));
			$manager->persist($newMovie);
		}
		$manager->flush();
	}

}
