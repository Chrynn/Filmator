<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\TagReadEntity;
use App\Model\Database\Entity\TagWatchEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;


final class TagFixture implements FixtureInterface
{

	public function load(ObjectManager $manager): void
	{
		$tags = Neon::decodeFile(__DIR__ . "/content/tag.neon");

		foreach ($tags as $type => $tag) {
			if ($type === 'watch') {
				foreach ($tag as $value) {
					$newTag = new TagWatchEntity();
					$newTag->setTitle($value);
					$manager->persist($newTag);
				}
			}
			if ($type === 'read') {
				foreach ($tag as $value) {
					$newTag = new TagReadEntity();
					$newTag->setTitle($value);
					$manager->persist($newTag);
				}
			}
		}
		$manager->flush();
	}

}
