<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Trailer;

final class TrailerFacade
{

	public function getTrailerLink(string $link): string
	{
		$linkArray = explode("/", $link);
		$videoCode = $linkArray[3];

		return "https://youtube.com/embed/" . $videoCode;
	}

}