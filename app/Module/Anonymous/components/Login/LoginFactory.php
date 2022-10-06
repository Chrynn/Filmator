<?php declare(strict_types = 1);

namespace App\Module\Anonymous\components\Login;

interface LoginFactory
{

	public function create(): Login;

}
