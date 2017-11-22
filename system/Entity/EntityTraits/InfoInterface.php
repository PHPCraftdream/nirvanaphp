<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldsFactoryInterface;

	interface InfoInterface {
		public function getPageSize(): int;

		public function setPageSize(int $pageSize);

		public function getPrimaryKey(): string;

		public function setPrimaryKey(string $primaryKey);

		public function setDatabase(string $val);

		public function setPrefix(string $val);

		public function getName(): string;

		public function getTable(): string;

		public function setColsSelect(array $value);

		public function getColsSelect(): array;

		public function fields(FieldSetInterface $set, FieldsFactoryInterface $factory);

		public function getFieldSet(): FieldSetInterface;
	}
}