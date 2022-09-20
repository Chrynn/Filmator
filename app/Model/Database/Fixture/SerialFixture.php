<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\SerialEntity;
use App\Model\Facade\Admin\NewContentFacade;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Utils\Strings;


final class SerialFixture implements FixtureInterface
{

	public function load(ObjectManager $manager): void
	{
		$serials = Neon::decodeFile(__DIR__ . "/content/serial.neon");

		foreach ($serials as $serial) {
			$newSerial = new SerialEntity();
			$newSerial->setName($serial['title']);
			$newSerial->setSlug(Strings::webalize($serial['title']));
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
			$newSerial->setTrailer(NewContentFacade::getTrailerLink($serial['trailer']));
			$manager->persist($newSerial);
		}
		$manager->flush();
	}

}
