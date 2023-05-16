<?php

declare(strict_types=1);

namespace App\Module\Admin\Movie\components\MovieForm;

interface IOnSaveEvent
{
	public function fire(bool $success, ?int $id = null, ?string $message = null): void;
}