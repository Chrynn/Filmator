<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nette\DI\Container;
use Nette\InvalidStateException;


class AbstractFixture implements FixtureInterface
{

	private ?Container $container = null;

	public function load(ObjectManager $manager):void
	{
	}

	public function setContainer(Container $container): void
	{
		$this->container = $container;
	}

	public function getContainer(): Container
	{
		if ($this->container === null) {
			throw new InvalidStateException("container is null");
		}
		return $this->container;
	}

}