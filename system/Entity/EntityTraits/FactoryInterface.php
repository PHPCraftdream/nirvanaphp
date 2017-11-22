<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use Aura\SqlQuery\Common\InsertInterface;
	use Aura\SqlQuery\Common\SelectInterface;
	use Aura\SqlQuery\Common\UpdateInterface;

	interface FactoryInterface {
		public function getTableColumns(): array;

		public function getTableIndexes(): array;

		public function newSelect($table = NULL): SelectInterface;

		public function newInsert($table = NULL): InsertInterface;

		public function newUpdate($table = NULL): UpdateInterface;
	}
}