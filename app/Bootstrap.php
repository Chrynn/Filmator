<?php declare(strict_types = 1);

namespace App;

use Nette\Bootstrap\Configurator;

final class Bootstrap
{

	public static function boot(): Configurator
	{
		$configurator = new Configurator;
		$appDir = dirname(__DIR__);

		$configurator->setDebugMode(true); // enable for your remote IP
		$configurator->enableTracy($appDir . '/log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory($appDir . '/temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig($appDir . '/config/common.neon');
		$configurator->addConfig($appDir . '/config/local.neon');

		$configurator->addConfig($appDir . '/app/Model/Facade/facade.neon');
		$configurator->addConfig($appDir . '/app/Model/Service/service.neon');
		$configurator->addConfig($appDir . '/app/Module/factory.neon');

		return $configurator;
	}

}
