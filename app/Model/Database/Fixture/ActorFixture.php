<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\ActorEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nette\Utils\Strings;


final class ActorFixture implements FixtureInterface
{

	public function load(ObjectManager $manager): void
	{
		$actors = [
			[
				'name' => 'Silvester Stalone',
				'imagePoster' => 'img/fixture/actor/sylvester-stalone_poster.jpg',
				'imageBanner' => 'img/fixture/actor/sylvester-stalone_banner.jpg',
			],
			[
				'name' => 'Dwayne Johnson',
				'imagePoster' => 'img/fixture/actor/dwayne-johnson_poster.jpg',
				'imageBanner' => 'img/fixture/actor/dwayne-johnson_banner.jpg',
			],
			[
				'name' => 'Jason Statham',
				'imagePoster' => 'img/fixture/actor/jason-statham_poster.jpg',
				'imageBanner' => 'img/fixture/actor/jason-statham_banner.jpg',
			],
			[
				'name' => 'Keyanu Reaves',
				'imagePoster' => 'img/fixture/actor/keyanu-reaves_poster.jpg',
				'imageBanner' => 'img/fixture/actor/keyanu-reaves_banner.jpg',
			],
			[
				'name' => 'Arnold Schwanceneger',
				'imagePoster' => 'img/fixture/actor/arnold-schwarzeneger_poster.jpg',
				'imageBanner' => 'img/fixture/actor/arnold-schwarzeneger_banner.jpg',
			],
			[
				'name' => 'Johny Depp',
				'imagePoster' => 'img/fixture/actor/johny-depp_poster.jpg',
				'imageBanner' => 'img/fixture/actor/johny-depp_banner.jpg',
			],
			[
				'name' => 'Robert Downey Jr.',
				'imagePoster' => 'img/fixture/actor/robert-downey-jr_poster.jpg',
				'imageBanner' => 'img/fixture/actor/robert-downey-jr_banner.jpg',
			],
    ];
		foreach ($actors as $actor) {
			$newActor = new ActorEntity();
			$newActor->setName($actor['name']);
			$newActor->setSlug(Strings::webalize($actor['name']));
			$newActor->setImagePoster($actor['imagePoster']);
			$newActor->setImageBanner($actor['imageBanner']);
			$manager->persist($newActor);
		}
		$manager->flush();
	}

}
