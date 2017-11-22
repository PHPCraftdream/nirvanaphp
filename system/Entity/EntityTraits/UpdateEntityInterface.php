<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\UpdateDataResultInterface;

	interface UpdateEntityInterface {
		public function updateById(array $data, $id): UpdateDataResultInterface;

		public function updateBy(array $data, callable $queryCallback): UpdateDataResultInterface;

		public function updateByField(array $data, string $field, string $value): UpdateDataResultInterface;
	}
}