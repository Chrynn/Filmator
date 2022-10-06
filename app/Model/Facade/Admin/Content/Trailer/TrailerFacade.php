<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Trailer;

final class TrailerFacade implements ITrailerFacade
{

	private const VIDEO_PREFIX = "https://youtube.com/embed/";


	public function getTrailerLink(string $link): string
	{
		$linkArray = explode("/", $link);
		$videoCode = $linkArray[3];

		return self::VIDEO_PREFIX . $videoCode;
	}

}
