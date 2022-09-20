<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Admin\NewContentFacade;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Utils\Strings;


final class MovieFixture implements FixtureInterface
{

	public function load(ObjectManager $manager): void
	{
		$movies = Neon::decodeFile(__DIR__ . "/content/movie.neon");

		foreach ($movies as $movie) {
			$newMovie = new MovieEntity();
			$newMovie->setName($movie['title']);
			$newMovie->setSlug(Strings::webalize($movie['title']));
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
			$newMovie->setTrailer(NewContentFacade::getTrailerLink($movie['trailer']));
			$manager->persist($newMovie);
		}
		$manager->flush();
	}

}
