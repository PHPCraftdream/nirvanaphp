<?php

namespace PHPCraftdream\NirvanaPHP\Entity {

	interface TableConstructorInterface {
		public function makeCreateTableSql(EntityInterface $entity): string;

		public function createTable(EntityInterface $entity);

		public function dropAllIndexes(EntityInterface $entity): array;

		public function createIndexes(EntityInterface $entity): array;

		public function getTableColumns(EntityInterface $entity): array;

		public function getTableIndexes(EntityInterface $entity): array;

		public function addNewColumns(EntityInterface $entity): array;

		public function changeColumns(EntityInterface $entity): array;

		public function deleteColumns(EntityInterface $entity): array;

		public function constructTable(EntityInterface $entity);
	}
}
