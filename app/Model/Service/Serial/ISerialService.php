<?php declare(strict_types = 1);

namespace App\Model\Service\Serial;

use App\Model\Database\Entity\SerialEntity;

interface ISerialService
{

	public function getSerials(): array;

	public function getSerialBySlug(string $slug): SerialEntity;

	public function getSerialsByLimit(int $limit): array;

}
