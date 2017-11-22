<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataProcess {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\IterateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityInterface;

	interface ReadDataRulesInterface {
		public function unserialize(EntityInterface $entity, IterateInterface $list, string $fieldName, $args);
	}
}