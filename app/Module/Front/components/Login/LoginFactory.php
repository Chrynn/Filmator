<?php declare(strict_types = 1);

namespace App\Module\Front\components\Login;

interface LoginFactory
{

	public function create(): Login;

}
