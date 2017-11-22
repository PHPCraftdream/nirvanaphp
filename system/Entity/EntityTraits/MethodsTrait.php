<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use Aura\SqlQuery\Common\InsertInterface;
	use Aura\SqlQuery\Common\SelectInterface;
	use Aura\SqlQuery\Common\UpdateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\CreateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\EditableContainerInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\IterateInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\ListDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\OneDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\PageDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\UpdateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\ReadDataRulesInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataRulesInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityInterface;
	use PHPCraftdream\NirvanaPHP\Entity\FactoryForEntityInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;
	use PHPCraftdream\NirvanaPHP\Tools\QueryExInterface;

	trait MethodsTrait {
		abstract protected function assertMethodExists($obj, string $method, string $addMessage = '');

		abstract protected function clearDataFields(array $data): array;

		abstract protected function fillListWithExSelectData(ListDataInterface $result, SelectInterface $selectQuery);

		abstract protected function fillObjWithExSelectData(OneDataInterface $result, SelectInterface $selectQuery);

		abstract protected function getMe(): EntityInterface;

		abstract protected function getNewListData(): ListDataInterface;

		abstract protected function getNewOneData(): OneDataInterface;

		abstract protected function getNewPageData(): PageDataInterface;

		abstract protected function getQueryEx(): QueryExInterface;

		abstract protected function getReadDataRules(): ReadDataRulesInterface;

		abstract protected function getSaveDataRules(): SaveDataRulesInterface;

		abstract protected function newCreateDataResult(): CreateDataResultInterface;

		abstract protected function newDataManager(array $requestData, array $saveData, array $dbData): SaveDataManagerInterface;

		abstract protected function newEditableContainer($data): EditableContainerInterface;

		abstract protected function newUpdateDataResult(): UpdateDataResultInterface;

		abstract protected function onCreate(SaveDataManagerInterface $saveDataManager);

		abstract protected function onRead(IterateInterface $list);

		abstract protected function onSave(SaveDataManagerInterface $saveDataManager);

		abstract protected function onUpdate(SaveDataManagerInterface $saveDataManager);

		abstract protected function processReadItr(IterateInterface $data);

		abstract protected function processUpdateDataRules(SaveDataManagerInterface $saveDataManager);

		abstract public function getColsSelect(): array;

		abstract public function getEntityFactory(): FactoryForEntityInterface;

		abstract public function getFieldSet(): FieldSetInterface;

		abstract public function getName(): string;

		abstract public function getPrimaryKey(): string;

		abstract public function getTable(): string;

		abstract public function newInsert($table = NULL): InsertInterface;

		abstract public function newSelect($table = NULL): SelectInterface;

		abstract public function newUpdate($table = NULL): UpdateInterface;

		abstract public function readById($id): OneDataInterface;

		abstract public function existsById($id): bool;

		abstract public function getCount(callable $queryCallback = NULL): int;

		abstract public function readAll(callable $queryCallback = NULL): ListDataInterface;

		abstract public function readByField(string $field, string $value, callable $queryCallback = NULL): ListDataInterface;

		abstract public function readOne(callable $queryCallback = NULL): OneDataInterface;

		abstract public function readPage(int $page, callable $queryCallback = NULL): PageDataInterface;

		abstract public function readByFieldArray(string $field, array $values, callable $queryCallback = NULL): ListDataInterface;

		abstract public function readByIds(array $ids, callable $queryCallback = NULL): ListDataInterface;

		abstract public function pageByField(int $page, string $field, string $value, callable $queryCallback = NULL): PageDataInterface;
	}
}