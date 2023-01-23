<?php declare(strict_types = 1);

namespace App\Model\Service\PermanentLogin;

use App\Model\Database\Entity\PermanentLoginEntity;

interface IPermanentLoginService
{

	public function add(string $email): array;

	public function delete(int $id): void;

	public function getTokenById(string $tokenId): ?PermanentLoginEntity;

}
