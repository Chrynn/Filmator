<?php

declare(strict_types=1);

namespace App\Module\Admin\Movie\components\MovieForm;

interface MovieFormFactory
{

	public function create(IOnSaveEvent $event): MovieForm;

}