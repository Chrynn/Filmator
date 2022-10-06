<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Image;

interface IImageFacade
{

	public function changeBannerSize(string $imageName, string $imagePath): string;

	public function changePosterSize(string $imageName, string $imagePath): string;

}
