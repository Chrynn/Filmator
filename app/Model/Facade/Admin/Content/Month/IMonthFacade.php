<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Month;

use DateTime;

interface IMonthFacade
{

	public function getMonth(DateTime $timeNow): string;

}
