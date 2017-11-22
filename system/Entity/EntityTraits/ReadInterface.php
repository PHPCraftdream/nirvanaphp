<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\ListDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\OneDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\PageDataInterface;

	interface ReadInterface {
		public function getCount(callable $queryCallback = NULL): int;

		public function existsById($id): bool;

		public function readPage(int $page, callable $queryCallback = NULL): PageDataInterface;

		public function readById($id): OneDataInterface;

		public function readAll(callable $queryCallback = NULL): ListDataInterface;

		public function readByField(string $field, string $value): ListDataInterface;

		public function readOne(callable $queryCallback = NULL): OneDataInterface;

		public function readByFieldArray(string $field, array $values, callable $queryCallback = NULL): ListDataInterface;

		public function readByIds(array $ids, callable $queryCallback = NULL): ListDataInterface;
	}
}