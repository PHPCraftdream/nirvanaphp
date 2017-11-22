<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use Aura\SqlQuery\Common\InsertInterface;
	use Aura\SqlQuery\Common\SelectInterface;
	use Aura\SqlQuery\Common\UpdateInterface;
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

	trait FactoryTrait {
		use MethodsTrait;

		public function getTableColumns(): array {
			return $this->getEntityFactory()->getTableColumns($this->getMe());
		}

		public function getTableIndexes(): array {
			return $this->getEntityFactory()->getTableIndexes($this->getMe());
		}

		public function newSelect($table = NULL): SelectInterface {
			$select = $this->getQueryFactory()->newSelect();

			$select->cols($this->getColsSelect());
			$select->from($table ? $table : $this->getTable());

			return $select;
		}

		public function newInsert($table = NULL): InsertInterface {
			$insertQuery = $this->getQueryFactory()->newInsert();
			$insertQuery->into($table ? $table : $this->getTable());

			return $insertQuery;
		}

		public function newUpdate($table = NULL): UpdateInterface {
			$updateQuery = $this->getQueryFactory()->newUpdate();
			$updateQuery->table($table ? $table : $this->getTable());

			return $updateQuery;
		}

		//-------------------------------------------------------------------------

		protected function assertEditableContainerInterface(EditableContainerInterface $data): EditableContainerInterface {
			return $data;
		}

		protected function newFieldSet(): FieldSetInterface {
			return $this->getEntityFactory()->newFieldSet();
		}

		protected function getSaveDataRules(): SaveDataRulesInterface {
			return $this->getEntityFactory()->getSaveDataRules();
		}

		protected function getFieldsFactory(): FieldsFactoryInterface {
			return $this->getEntityFactory()->getFieldFactory();
		}

		protected function newEditableContainer($data): EditableContainerInterface {
			$container = $this->getEntityFactory()->newEditableContainer($data);

			return $container;
		}

		protected function newDataManager(array $requestData, array $saveData, array $dbData): SaveDataManagerInterface {
			$saveDataManager = $this->getEntityFactory()->newDataManager($requestData, $saveData, $dbData);
			$saveDataManager->setEntity($this->getMe());

			return $saveDataManager;
		}

		protected function getQueryFactory(): QueryFactoryInterface {
			return $this->getEntityFactory()->getQueryFactory();
		}

		protected function getQueryEx(): QueryExInterface {
			return $this->getEntityFactory()->getQueryEx();
		}

		protected function newCreateDataResult(): CreateDataResultInterface {
			return $this->getEntityFactory()->newCreateDataResult();
		}

		protected function getReadDataRules(): ReadDataRulesInterface {
			return $this->getEntityFactory()->getReadDataRules();
		}

		protected function getNewListData(): ListDataInterface {
			$obj = $this->getEntityFactory()->getNewListData($this->getName(), $this->getPrimaryKey());
			$obj->setEntity($this->getMe());

			return $obj;
		}

		protected function getNewPageData(): PageDataInterface {
			$obj = $this->getEntityFactory()->getNewPageData($this->getName(), $this->getPrimaryKey());
			$obj->setEntity($this->getMe());

			return $obj;
		}

		protected function getNewOneData(): OneDataInterface {
			$obj = $this->getEntityFactory()->getNewOneData($this->getName(), $this->getPrimaryKey());
			$obj->setEntity($this->getMe());

			return $obj;
		}

		protected function newUpdateDataResult(): UpdateDataResultInterface {
			return $this->getEntityFactory()->newUpdateDataResult();
		}
	}
}