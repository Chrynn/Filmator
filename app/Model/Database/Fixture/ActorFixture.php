<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\ActorEntity;
use Doctrine\Persistence\ObjectManager;
use Nette\Neon\Neon;
use Nette\Utils\Strings;
use Nettrine\Fixtures\ContainerAwareInterface;

final class ActorFixture extends AbstractFixture implements ContainerAwareInterface
{

	public function load(ObjectManager $manager): void
	{
		$actors = Neon::decodeFile(__DIR__ . "/content/actor.neon");

		foreach ($actors as $actor) {
			$newActor = new ActorEntity($actor['name']);
			$manager->persist($newActor);
		}
		$manager->flush();
	}

}
