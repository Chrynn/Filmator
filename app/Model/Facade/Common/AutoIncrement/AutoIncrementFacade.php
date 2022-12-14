<?php declare(strict_types = 1);

namespace App\Model\Facade\Common\AutoIncrement;

use Doctrine\ORM\EntityManagerInterface;

final class AutoIncrementFacade implements IAutoIncrementFacade
{

	public function __construct(
		private readonly EntityManagerInterface $entityManager
	) {}


	/**
	 * for each DB table set Auto Increment to 0
	 */
	public function resetAutoIncrement(): void
	{
		$metas = $this->entityManager->getMetadataFactory()->getAllMetadata();
		foreach ($metas as $meta) {
			// %s - placeholder in sprintf(placeholder, data) function
			$this->entityManager->getConnection()->executeQuery(sprintf(
				"ALTER TABLE `%s` AUTO_INCREMENT = 0",
				$this->entityManager->getClassMetadata($meta->getName())->getTableName()
			));
		}
	}

}
