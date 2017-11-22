<?php
namespace PHPCraftdream\NirvanaPHP\Entity\Fields {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\IterateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;

	interface FieldOnSaveInterface {
		public function onSave(SaveDataManagerInterface $saveDataManager);

		public function clearOnSave(): FieldInterface;

		public function setOnSave(string $name, $args = []): FieldInterface;

		public function getOnSave(): array;

		public function unsetOnSave(string $name): FieldInterface;
	}

	interface FieldOnCreateInterface {
		public function onCreate(SaveDataManagerInterface $saveDataManager);

		public function clearOnCreate(): FieldInterface;

		public function setOnCreate(string $name, $args = []): FieldInterface;

		public function getOnCreate(): array;

		public function unsetOnCreate(string $name): FieldInterface;
	}

	interface FieldOnReadInterface {
		public function onRead(IterateInterface $list);

		public function clearOnRead(): FieldInterface;

		public function setOnRead(string $name, $args = []): FieldInterface;

		public function getOnRead(): array;

		public function unsetOnRead(string $name): FieldInterface;
	}

	interface FieldOnUpdateInterface {
		public function onUpdate(SaveDataManagerInterface $saveDataManager);

		public function clearOnUpdate(): FieldInterface;

		public function setOnUpdate(string $name, $args = []): FieldInterface;

		public function getOnUpdate(): array;

		public function unsetOnUpdate(string $name): FieldInterface;
	}

	interface FieldOnDeleteInterface {
		public function clearOnDelete(): FieldInterface;

		public function setOnDelete(string $name, $args = []): FieldInterface;

		public function getOnDelete(): array;

		public function unsetOnDelete(string $name): FieldInterface;
	}

	interface FieldSqlDataInterface {
		public function getSqlData(): array;

		public function setSqlData(array $data): FieldInterface;

		public function setSqlType($val): FieldInterface;

		public function getSqlType();

		public function setSqlAutoincrement(bool $val): FieldInterface;

		public function getSqlAutoincrement(): bool;

		public function setSqlLength($val): FieldInterface;

		public function getSqlLength();

		public function setSqlIndex($val): FieldInterface;

		public function getSqlIndex();

		public function setSqlDefault($val): FieldInterface;

		public function getSqlDefault();

		public function setSqlNull(bool $val): FieldInterface;

		public function getSqlNull(): bool;
	}

	interface FieldAttrsInterface {
		public function clearAttrs(): FieldInterface;

		public function setAttr(string $name, $val): FieldInterface;

		public function getAttr(string $name);

		public function getAttrs(): array;

		public function unsetAttr(string $name): FieldInterface;
	}

	interface FieldInterface extends
		FieldOnCreateInterface,
		FieldOnUpdateInterface,
		FieldOnSaveInterface,
		FieldOnReadInterface,
		FieldOnDeleteInterface,
		FieldSqlDataInterface,
		FieldAttrsInterface {
		public function clearRules(): FieldInterface;

		public function getData(): array;

		public function setData(array $data): FieldInterface;

		public function getName(): string;

		public function setName(string $val): FieldInterface;

		public function getTitle(): string;

		public function setTitle(string $val): FieldInterface;

		public function getPlaceholder(): string;

		public function setPlaceholder(string $val): FieldInterface;

		public function getType(): string;

		public function setType(string $val): FieldInterface;

		public function isVirtual(): bool;
	}
}