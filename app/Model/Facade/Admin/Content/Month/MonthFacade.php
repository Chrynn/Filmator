<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Month;

use DateTime;

final class MonthFacade implements IMonthFacade
{

	public function getMonth(DateTime $timeNow): string
	{
		$month = (int) $timeNow->format("m");
		return EMonthFacade::tryFrom($month)->getMonth();
	}

}
