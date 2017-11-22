<?php

namespace PHPCraftdream\NirvanaPHP\Entity {

	use PHPCraftdream\NirvanaPHP\Bridges\QueryFactory\QueryFactoryInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\CreateDataResult;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\CreateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\EditableContainer;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\EditableContainerInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\ListData;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\ListDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\OneData;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\OneDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\PageData;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\PageDataInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\UpdateDataResult;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\UpdateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\ReadDataRules;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\ReadDataRulesInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManager;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataRules;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataRulesInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSet;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldSetInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldsFactory;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\FieldsFactoryInterface;
	use PHPCraftdream\NirvanaPHP\Framework\FrameworkInterface;
	use PHPCraftdream\NirvanaPHP\Tools\QueryExInterface;

	class FactoryForEntity implements FactoryForEntityInterface {
		protected $queryFactory;
		protected $app;
		protected $fieldsFactory;
		protected $dataProcessor;
		protected $saveDataRules;
		protected $queryEx;
		protected $tableConstructor;

		public function __construct(FrameworkInterface $app) {
			$this->app = $app;
		}

		protected function getApp(): FrameworkInterface {
			return $this->app;
		}

		public function newCreateDataResult(): CreateDataResultInterface {
			return new CreateDataResult();
		}

		public function newUpdateDataResult(): UpdateDataResultInterface {
			return new UpdateDataResult();
		}

		public function getQueryFactory(): QueryFactoryInterface {
			if (empty($this->queryFactory)) {
				$this->queryFactory = $this->getApp()->getQueryFactory();
			}

			return $this->queryFactory;
		}

		public function getFieldFactory(): FieldsFactoryInterface {
			if (empty($this->fieldsFactory)) {
				$this->fieldsFactory = new FieldsFactory();
			}

			return $this->fieldsFactory;
		}

		public function getSaveDataRules(): SaveDataRulesInterface {
			if (empty($this->saveDataRules)) {
				$this->saveDataRules = new SaveDataRules($this);
			}

			return $this->saveDataRules;
		}

		public function getReadDataRules(): ReadDataRulesInterface {
			if (empty($this->readDataRules)) {
				$this->readDataRules = new ReadDataRules($this);
			}

			return $this->readDataRules;
		}

		public function getQueryEx(): QueryExInterface {
			if (empty($this->queryEx)) {
				$this->queryEx = $this->getApp()->getQueryEx();
			}

			return $this->queryEx;
		}

		public function getTableConstructor(): TableConstructorInterface {
			if (!empty($this->tableConstructor)) {
				return $this->tableConstructor;
			}

			$this->tableConstructor = new TableConstructorMySQL($this);

			return $this->tableConstructor;
		}

		public function getTableColumns(EntityInterface $entity): array {
			$tableConstructor = $this->getTableConstructor();
			$res = $tableConstructor->getTableColumns($entity);

			return $res;
		}

		public function getTableIndexes(EntityInterface $entity): array {
			$tableConstructor = $this->getTableConstructor();
			$res = $tableConstructor->getTableIndexes($entity);

			return $res;
		}

		public function newEditableContainer($data): EditableContainerInterface {
			return new EditableContainer($data);
		}

		public function newDataManager(array $requestData, array $saveData, array $dbData): SaveDataManagerInterface {
			return new SaveDataManager($requestData, $saveData, $dbData);
		}

		public function newFieldSet(): FieldSetInterface {
			return new FieldSet();
		}

		public function getNewListData(string $name, string $primaryKey): ListDataInterface {
			$obj = new ListData($name, $primaryKey);
			$obj->setFactoryForEntity($this);

			return $obj;
		}

		public function getNewPageData(string $name, string $primaryKey): PageDataInterface {
			$obj = new PageData($name, $primaryKey);
			$obj->setFactoryForEntity($this);
			return $obj;
		}

		public function getNewOneData(string $name, string $primaryKey): OneDataInterface {
			$obj = new OneData($name, $primaryKey);
			$obj->setFactoryForEntity($this);

			return $obj;
		}

		public function getEntityHub(): EntityHubInterface {
			return $this->getApp()->getEntityHub();
		}

		public function getEntity(string $name): EntityInterface {
			return $this->getEntityHub()->get($name);
		}

		public function existsEntity(string $name): bool {
			return !!$this->getEntityHub()->exists($name);
		}
	}
}