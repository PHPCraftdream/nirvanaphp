<?php

namespace PHPCraftdream\NirvanaPHP\Entity {

	use PHPCraftdream\NirvanaPHP\Bridges\QueryFactory\QueryFactoryInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\CreateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\EditableContainerInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\ListDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\OneDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\PageDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\UpdateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\ReadDataRulesInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataRulesInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldsFactoryInterface;
	use PHPCraftdream\NirvanaPHP\Tools\QueryExInterface;

	interface FactoryForEntityInterface {
		public function newCreateDataResult(): CreateDataResultInterface;

		public function newUpdateDataResult(): UpdateDataResultInterface;

		public function getQueryFactory(): QueryFactoryInterface;

		public function getFieldFactory(): FieldsFactoryInterface;

		public function getSaveDataRules(): SaveDataRulesInterface;

		public function getReadDataRules(): ReadDataRulesInterface;

		public function getQueryEx(): QueryExInterface;

		public function getTableConstructor(): TableConstructorInterface;

		public function getTableColumns(EntityInterface $entity): array;

		public function getTableIndexes(EntityInterface $entity): array;

		public function newEditableContainer($data): EditableContainerInterface;

		public function newDataManager(array $requestData, array $saveData, array $dbData): SaveDataManagerInterface;

		public function newFieldSet(): FieldSetInterface;

		public function getNewListData(string $name, string $primaryKey): ListDataInterface;

		public function getNewPageData(string $name, string $primaryKey): PageDataInterface;

		public function getNewOneData(string $name, string $primaryKey): OneDataInterface;

		public function getEntityHub(): EntityHubInterface;

		public function getEntity(string $name): EntityInterface;

		public function existsEntity(string $name): bool;
	}
}