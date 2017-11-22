<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\CreateDataResultInterface;

	interface CreateInterface {
		public function create(array $data, callable $queryCallback = NULL): CreateDataResultInterface;
	}
}