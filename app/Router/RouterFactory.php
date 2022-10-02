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

		$routerAnonymous = new RouteList("Anonymous");
		$routerAnonymous->addRoute('movie/<url>', 'Movie:detail');
		$routerAnonymous->addRoute('serial/<url>', 'Serial:detail');
		$routerAnonymous->addRoute('actor/<url>', 'Actor:detail');
		$routerAnonymous->addRoute('article/<url>', 'Article:detail');
		$routerAnonymous->addRoute('profile/<url>', 'Profile:detail');
		$routerAnonymous->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');

		$router = new RouteList();
		$router->add($routerAdmin);
		$router->add($routerUser);
		$router->add($routerAnonymous);

		return $router;
	}

}
