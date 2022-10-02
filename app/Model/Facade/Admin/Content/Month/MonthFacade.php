<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Month;

use DateTime;

final class MonthFacade
{

	private const MONTH_ONE = "ledna";
	private const MONTH_TWO = "února";
	private const MONTH_THREE = "března";
	private const MONTH_FOUR = "dubna";
	private const MONTH_FIVE = "května";
	private const MONTH_SIX = "června";
	private const MONTH_SEVEN = "července";
	private const MONTH_EIGHT = "sprna";
	private const MONTH_NINE = "září";
	private const MONTH_TEN = "října";
	private const MONTH_ELEVEN = "listopadu";
	private const MONTH_TWELVE = "prosince";
	private const ERROR = "";


	public function getMonth(DateTime $timeNow): string
	{
		$month = $timeNow->format("m");
		if ($month == 1) {
			return self::MONTH_ONE;
		} elseif ($month == 2) {
			return self::MONTH_TWO;
		} elseif ($month == 3) {
			return self::MONTH_THREE;
		} elseif ($month == 4) {
			return self::MONTH_FOUR;
		} elseif ($month == 5) {
			return self::MONTH_FIVE;
		} elseif ($month == 6) {
			return self::MONTH_SIX;
		} elseif ($month == 7) {
			return self::MONTH_SEVEN;
		} elseif ($month == 8) {
			return self::MONTH_EIGHT;
		} elseif ($month == 9) {
			return self::MONTH_NINE;
		} elseif ($month == 10) {
			return self::MONTH_TEN;
		} elseif ($month == 11) {
			return self::MONTH_ELEVEN;
		} elseif ($month == 12) {
			return self::MONTH_TWELVE;
		} else {
			return self::ERROR;
		}
	}

}
