<?php declare(strict_types = 1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{

	use Nette\StaticClass;


	public static function createRouter(): RouteList
	{
		$routerAdmin = new RouteList("Admin");
		$routerAdmin->addRoute('admin/<presenter>/<action>[/<id>]', 'Homepage:default');

		$routerUser = new RouteList("User");
		$routerUser->addRoute('user/<presenter>/<action>[/<id>]', 'Homepage:default');

		$routerFront = new RouteList("Front");
		$routerFront->addRoute('movie/<url>', 'Movie:detail');
		$routerFront->addRoute('serial/<url>', 'Serial:detail');
		$routerFront->addRoute('actor/<url>', 'Actor:detail');
		$routerFront->addRoute('article/<url>', 'Article:detail');
		$routerFront->addRoute('profile/<url>', 'Profile:detail');
		$routerFront->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');

		$router = new RouteList();
		$router->add($routerAdmin);
		$router->add($routerUser);
		$router->add($routerFront);

		return $router;
	}

}
