<?php

namespace PHPCraftdream\NirvanaPHP\Entity {

	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\CreateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\FactoryInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\InfoInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\ReadInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityTraits\UpdateEntityInterface;

	interface EntityInterface extends
		CreateInterface, FactoryInterface, InfoInterface, ReadInterface, UpdateEntityInterface {
		public function getEntityFactory(): FactoryForEntityInterface;
		public function getLastQuery();
	}
}