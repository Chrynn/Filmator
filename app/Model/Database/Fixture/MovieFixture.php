<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\MovieEntity;
use App\Model\Facade\Admin\Content\Image\ImageFacade;
use App\Model\Facade\Admin\Content\Trailer\TrailerFacade;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Utils\Strings;
use Nettrine\Fixtures\ContainerAwareInterface;

final class MovieFixture extends AbstractFixture implements ContainerAwareInterface
{

	private string $contentImagePath = __DIR__ . '/content/img/movie';

	private string $contentFixturePath = __DIR__ . '/content/movie.neon';


	public function getTrailerFacade(): TrailerFacade
	{
		return $this->getContainer()->getByType(TrailerFacade::class);
	}


	public function getImageFacade(): ImageFacade
	{
		return $this->getContainer()->getByType(ImageFacade::class);
	}


	public function load(ObjectManager $manager): void
	{
		$movies = Neon::decodeFile($this->contentFixturePath);

		foreach ($movies as $movie) {
			$newMovie = new MovieEntity(
				$movie['title']
			);
			$newMovie->setYear($movie['year']);
			$newMovie->setRating($movie['rating']);
			$newMovie->setTeaser($movie['teaser']);
			$newMovie->setDescription($movie['description']);
			$newMovie->setTrailer($this->getTrailerFacade()->getTrailerLink($movie['trailer']));

			$manager->persist($newMovie);
			$manager->flush();

			$movieId = $newMovie->getId();
			foreach ($movie['image'] as $type => $value) {
				if ($type === 'imageBanner') {
					$this->getImageFacade()->createImageFromFile(
						"$this->contentImagePath/$value", $movieId,
						ImageFacade::CONTENT_TYPE_MOVIE,
						ImageFacade::IMAGE_TYPE_BANNER
					);
				}
				if ($type === 'imagePoster') {
					$this->getImageFacade()->createImageFromFile(
						"$this->contentImagePath/$value", $movieId,
						ImageFacade::CONTENT_TYPE_MOVIE,
						ImageFacade::IMAGE_TYPE_POSTER
					);
				}
			}
		}
	}

}
