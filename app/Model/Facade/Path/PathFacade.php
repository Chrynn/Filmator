<?php declare(strict_types = 1);

namespace App\Model\Facade\Path;

use Nette\Http\Request;

final class PathFacade
{

	private Request $httpRequest;

	public function __construct(Request $httpRequest)
	{
		$this->httpRequest = $httpRequest;
	}

	public function getBasePath(): string
	{
		return $this->httpRequest->getUrl()->getAuthority() . $this->httpRequest->getUrl()->getPath();
	}

	public function getModuleActive(): string
	{
		$path = $this->httpRequest->getUrl()->getPath();
		$pathModules = explode("/", $path);
		return $pathModules[1];
	}

}
