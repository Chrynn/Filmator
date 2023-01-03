<?php declare(strict_types=1);

namespace Pd\PHPStan\Rules;

class Psr4NamespaceCheckRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Stmt\ClassLike::class;
	}


	/**
	 * @return array<string>
	 *
	 * @param \PhpParser\Node\Stmt\ClassLike $node
	 */
	public function processNode(
		\PhpParser\Node $node,
		\PHPStan\Analyser\Scope $scope,
	): array
	{
		$namespace = (string) $node->namespacedName;
		if ($namespace === '') {
			return [
				'Class does not have a defined namespace',
			];
		}

		$filePath = \str_replace('\\', '/', $scope->getFile());

		if (\preg_match('@/(app(-[a-z-]+)?)/@', $filePath, $matches) === FALSE) {
			return [];
		}

		if ($matches === []) {
			return [];
		}

		$directory = $matches[1];
		$ns = $this->getNamespaceFromDirectoryName($directory);

		$positionInDirectoryNamed = \strpos($filePath, $directory . '/');
		if ($positionInDirectoryNamed === FALSE) {
			return [];
		}

		$namespacedName = \preg_replace('/' . $directory . '/', $ns, \substr($filePath, $positionInDirectoryNamed), 1);

		$filename = \pathinfo($namespacedName, \PATHINFO_FILENAME);
		$pathname = \pathinfo($namespacedName, \PATHINFO_DIRNAME);

		$pathname = "Pd" . \substr($pathname, 3);

		$psr4Namespace = \str_replace('/', '\\', \sprintf('%s/%s', $pathname, $filename));

		if ($psr4Namespace === $namespace) {
			return [];
		}

		return [
			\sprintf('Class like namespace "%s" does not follow PSR-4 configuration, use %s', $namespace, $psr4Namespace),
		];
	}


	private function getNamespaceFromDirectoryName(string $directory): string
	{
		return \implode(
			'', \array_map(static function (string $item): string {
				return \ucfirst($item);
			}, \explode('-', $directory))
		);
	}

}
