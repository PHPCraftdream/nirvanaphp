<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	use PHPCraftdream\NirvanaPHP\Entity\EntityInterface;
	use PHPCraftdream\NirvanaPHP\Entity\FactoryForEntityInterface;

	interface ForeignContainerInterface {
		public function getKeyName(): string;

		public function getName(): string;

		public function setMainList(ForeignContainerInterface $list);

		public function getMainList(): ListDataInterface;

		public function addForeign(ListDataInterface $list, string $fieldName): ForeignContainerInterface;

		public function getForeign(string $fieldName, string $entityName = NULL): ForeignContainerInterface;

		public function existsForeign(string $fieldName, string $entityName = NULL): bool;

		public function addSubData(ListDataInterface $list): ForeignContainerInterface;

		public function getSubData(string $name): ListDataInterface;

		public function existsSubData(string $name): bool;

		public function getEntity(): EntityInterface;

		public function setEntity(EntityInterface $entity);

		public function setFactoryForEntity(FactoryForEntityInterface $factory);

		public function getFactoryForEntity(): FactoryForEntityInterface;

		public function loadSubData($subNames = NULL);

		public function isMain(): bool;

		public function loadForeignData();
	}
}