<?php declare(strict_types=1);

namespace App\Model\Facade\Anonymous\Auth;

use Nette\Security\IIdentity;

final class UserIdentityFacade implements IIdentity
{

	private int $id;


	public function __construct(int $id)
	{
		$this->id = $id;
	}


	public function getId(): int
	{
		return $this->id;
	}


	/**
	 * @return array<int, string>
	 */
	public function getRoles(): array
	{
		return [];
	}

}
