<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Month;

enum EMonthFacade: int
{

	case one = 1;
	case two = 2;
	case three = 3;
	case four = 4;
	case five = 5;
	case six = 6;
	case seven = 7;
	case eight = 8;
	case nine = 9;
	case ten = 10;
	case eleven = 11;
	case twelve = 12;


	public function getMonth(): string
	{
		return match($this) {
			EMonthFacade::one => "ledna",
			EMonthFacade::two => "února",
			EMonthFacade::three => "března",
			EMonthFacade::four => "dubna",
			EMonthFacade::five => "května",
			EMonthFacade::six => "června",
			EMonthFacade::seven => "července",
			EMonthFacade::eight => "sprna",
			EMonthFacade::nine => "září",
			EMonthFacade::ten => "října",
			EMonthFacade::eleven => "listopadu",
			EMonthFacade::twelve => "prosince"
		};
	}

}
