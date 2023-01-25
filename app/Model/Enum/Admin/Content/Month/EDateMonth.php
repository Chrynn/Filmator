<?php declare(strict_types = 1);

namespace App\Model\Enum\Admin\Content\Month;

enum EDateMonth: int
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
			EDateMonth::one => "ledna",
			EDateMonth::two => "února",
			EDateMonth::three => "března",
			EDateMonth::four => "dubna",
			EDateMonth::five => "května",
			EDateMonth::six => "června",
			EDateMonth::seven => "července",
			EDateMonth::eight => "sprna",
			EDateMonth::nine => "září",
			EDateMonth::ten => "října",
			EDateMonth::eleven => "listopadu",
			EDateMonth::twelve => "prosince"
		};
	}

}
