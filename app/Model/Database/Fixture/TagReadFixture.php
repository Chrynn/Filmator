<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\TagReadEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;


final class TagReadFixture implements FixtureInterface
{

	public function load(ObjectManager $manager)
	{
		$tags = [
			[
				'title' => 'Novinky'
			],
			[
				'title' => 'Oznámení'
			],
		];
		foreach ($tags as $tag) {
			$newTag = new TagReadEntity();
			$newTag->setTitle($tag['title']);
			$manager->persist($newTag);
		}
		$manager->flush();
	}

}
