<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Image;

use Nette\Http\FileUpload;

interface IImageFacade
{

	public function createImageFromUpload(FileUpload $file, int $id, string $contentType, string $imageType): void;

	public function createImageFromFile(string $path, int $id, string $contentType, string $imageType): void;

}
