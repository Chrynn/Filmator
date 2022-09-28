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
		$routerAdmin->addRoute('admin/edit-movie/<id>', 'Edit:default');
		$routerAdmin->addRoute('admin/<presenter>/<action>[/<id>]', 'Homepage:default');

		$routerUser = new RouteList("User");
		$routerUser->addRoute('user/<presenter>/<action>[/<id>]', 'Homepage:default');

		$routerGhost = new RouteList("Ghost");
		$routerGhost->addRoute('movie/<url>', 'Movie:detail');
		$routerGhost->addRoute('serial/<url>', 'Serial:detail');
		$routerGhost->addRoute('actor/<url>', 'Actor:detail');
		$routerGhost->addRoute('article/<url>', 'Article:detail');
		$routerGhost->addRoute('profile/<url>', 'Profile:detail');
		$routerGhost->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');

		$router = new RouteList();
		$router->add($routerAdmin);
		$router->add($routerUser);
		$router->add($routerGhost);

		return $router;
	}

}
