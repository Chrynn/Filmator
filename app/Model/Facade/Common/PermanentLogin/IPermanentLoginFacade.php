<?php declare(strict_types = 1);

namespace App\Model\Facade\Common\PermanentLogin;

interface IPermanentLoginFacade
{

	public function setPermanentLogin(): void;

	public function removePermanentLogin(): void;

	public function setPermanentLoginCookie(string $email): void;

	public function getPermanentLoginCookie(): ?string;

	public function removePermanentLoginCookie(): void;

	public function verifyPermanentLogin(?string $tokenCookie): ?int;

}
