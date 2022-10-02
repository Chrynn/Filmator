<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Image;

use Nette\Utils\Image;
use Nette\Utils\Strings;

final class ImageFacade
{

	// Warning! www folder (as default) needn't be writeable! - sudo chmod 777 www/img
	private const RESULT_PATH = "img/cover/";
	private const COMPRESS = 80; // %

	private const BANNER_PREFIX = "_banner.jpg";
	private const BANNER_WIDTH = 1500;
	private const BANNER_HEIGHT = 844;

	private const POSTER_PREFIX = "_poster.jpg";
	private const POSTER_WIDTH = 712;
	private const POSTER_HEIGHT = 1000;

	private const SQUARE_WIDTH = "500px";
	private const SQUARE_HEIGHT = "500px";


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


	public function getSquareSize(string $imageName, string $imagePath): string
	{
		$slug = Strings::webalize($imageName);
		$newTitle = self::RESULT_PATH . $slug;
		$image = Image::fromFile($imagePath);
		$image->resize(self::SQUARE_WIDTH, self::SQUARE_HEIGHT);
		$image->sharpen();
		$image->save($newTitle, self::COMPRESS, Image::JPEG);

		return $newTitle;
	}

}
