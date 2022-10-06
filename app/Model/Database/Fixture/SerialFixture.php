<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Admin\Content\Trailer\TrailerFacade;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Utils\Strings;
use Nettrine\Fixtures\ContainerAwareInterface;

final class SerialFixture extends AbstractFixture implements ContainerAwareInterface
{

	public function getTrailerFacade(): TrailerFacade
	{
		return $this->getContainer()->getByType(TrailerFacade::class);
	}


	public function load(ObjectManager $manager): void
	{
		$serials = Neon::decodeFile(__DIR__ . "/content/serial.neon");

		foreach ($serials as $serial) {
			$newSerial = new SerialEntity();
			$title = $serial['title'];
			$newSerial->setName($title);
			$newSerial->setSlug(Strings::webalize($title));
			$newSerial->setYear($serial['year']);
			$newSerial->setRating($serial['rating']);
			$newSerial->setTeaser($serial['teaser']);
			$newSerial->setDescription($serial['description']);
			foreach ($serial['image'] as $type => $value) {
				if ($type === 'imageBanner') {
					$newSerial->setImageBanner($value);
				}
				if ($type === 'imagePoster') {
					$newSerial->setImagePoster($value);
				}
			}
			$newSerial->setTrailer($this->getTrailerFacade()->getTrailerLink($serial['trailer']));
			$manager->persist($newSerial);
		}
		$manager->flush();
	}

}
