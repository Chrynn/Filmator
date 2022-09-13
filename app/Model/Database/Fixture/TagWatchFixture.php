<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\TagWatchEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;


final class TagWatchFixture implements FixtureInterface
{

	public function load(ObjectManager $manager)
	{
		$tags = [
			[
				'title' => 'Trendy'
			],
			[
				'title' => 'Vojenský'
			],
			[
				'title' => 'Sportovní'
			]
		];
		foreach ($tags as $tag) {
			$newTag = new TagWatchEntity();
			$newTag->setTitle($tag['title']);
			$manager->persist($newTag);
		}
		$manager->flush();
	}

}
