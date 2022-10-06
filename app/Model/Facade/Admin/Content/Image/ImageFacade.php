<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Image;

use Nette\Utils\Image;
use Nette\Utils\Strings;

final class ImageFacade implements IImageFacade
{

	private const RESULT_PATH = "img/cover/"; // Warning! www folder (as default) needn't be writeable! - sudo chmod 777 www/img
	private const BANNER_PREFIX = "_banner.jpg";
	private const POSTER_PREFIX = "_poster.jpg";

	private const BANNER_WIDTH = 1500;
	private const BANNER_HEIGHT = 844;

	private const POSTER_WIDTH = 712;
	private const POSTER_HEIGHT = 1000;
	private const COMPRESS = 80;


	public function changeBannerSize(string $imageName, string $imagePath): string
	{
		$slug = Strings::webalize($imageName);
		$newTitle = self::RESULT_PATH . $slug . self::BANNER_PREFIX;
		$image = Image::fromFile($imagePath);
		$image->resize(self::BANNER_WIDTH, self::BANNER_HEIGHT);
		$image->save($newTitle, self::COMPRESS, Image::JPEG);

		return $newTitle;
	}


	public function changePosterSize(string $imageName, string $imagePath): string
	{
		$slug = Strings::webalize($imageName);
		$newTitle = self::RESULT_PATH . $slug . self::POSTER_PREFIX;
		$image = Image::fromFile($imagePath);
		$image->resize(self::POSTER_WIDTH, self::POSTER_HEIGHT);
		$image->sharpen();
		$image->save($newTitle, self::COMPRESS, Image::JPEG);

		return $newTitle;
	}

}
