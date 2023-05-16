<?php declare(strict_types = 1);

namespace App\Model\Facade\Admin\Content\Image;

use App\Model\Database\Entity\MovieEntity;
use Nette\Http\FileUpload;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;

final class ImageFacade implements IImageFacade
{
	public const CONTENT_TYPE_MOVIE = 'movie';
	public const CONTENT_TYPE_SERIAL = 'serial';
	public const CONTENT_TYPE_ACTOR = 'actor';

	public const IMAGE_TYPE_BANNER = 'banner';
	public const IMAGE_TYPE_POSTER = 'poster';

	// www folder needn't be writeable - chmod
	public const IMAGE_CONTENT_PATH = 'www/img/public';

	private int $compress = 80;


	/**
	 * @throws ImageException
	 */
	public function createImageFromUpload(FileUpload $file, int $id, string $contentType, string $imageType): void
	{
		if (!$file->isImage() || !$file->isOk()) {
			throw new ImageException('not an image');
		}

		$resultFolder = self::IMAGE_CONTENT_PATH . "/$contentType/$id";
		$resultFile = "$resultFolder/$id" . '_' . $imageType;

        // common mistake before ID folder
		FileSystem::createDir($resultFolder);

		$image = Image::fromFile($file->getTemporaryFile());
		$image->save("$resultFile.webp", $this->compress, Image::WEBP);
		$image->save("$resultFile.png", $this->compress, Image::PNG);
		$image->save("$resultFile.avif", $this->compress, Image::AVIF);
	}


	/**
	 * @throws ImageException
	 * @throws UnknownImageFileException
	 */
	public function createImageFromFile(string $path, int $id, string $contentType, string $imageType): void
	{
		$resultFolder = self::IMAGE_CONTENT_PATH . "/$contentType/$id";
		$resultFile = "$resultFolder/$id" . '_' . $imageType;

        FileSystem::createDir($resultFolder);

		$image = Image::fromFile($path);
		$image->save("$resultFile.webp", $this->compress, Image::WEBP);
		$image->save("$resultFile.png", $this->compress, Image::PNG);
		$image->save("$resultFile.avif", $this->compress, Image::AVIF);
	}

}
