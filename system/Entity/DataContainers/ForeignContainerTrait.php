<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {

	use Aura\SqlQuery\Common\SelectInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityInterface;
	use PHPCraftdream\NirvanaPHP\Entity\FactoryForEntityInterface;
	use PHPCraftdream\NirvanaPHP\Entity\Fields\ForeignKeyInterface;

	trait ForeignContainerTrait {
		protected $foreign = [];

		protected $isMain = NULL;
		protected $mainList = NULL;
		protected $sublist = [];

		protected $factoryForEntity = NULL;
		protected $entity = NULL;

		abstract public function getKeyName(): string;

		abstract public function getName(): string;

		public function setMainList(ForeignContainerInterface $list) {
			$this->mainList = $list;
		}

		public function getMainList(): ListDataInterface {
			if (empty($this->mainList)) {
				return $this;
			}

			return $this->mainList;
		}

		public function addForeign(ListDataInterface $list, string $fieldName): ForeignContainerInterface {
			$mainList = $this->getMainList();

			if ($mainList !== $this) {
				return $mainList->addForeign($mainList, $fieldName);
			}

			$list->setMainList($this);
			$this->foreign[$this->getName()][$fieldName] = $list;

			return $this;
		}

		public function getForeign(string $fieldName, string $entityName = NULL): ForeignContainerInterface {
			$mainList = $this->getMainList();

			if ($entityName === NULL)
				$entityName = $mainList->getName();

			if ($mainList !== $this) {
				return $mainList->getForeign($fieldName, $entityName);
			}

			if (!array_key_exists($entityName, $this->foreign)) {
				throw new ContainerException('Foreign list does not exist #1');
			}

			if (!array_key_exists($fieldName, $this->foreign[$entityName])) {
				throw new ContainerException('Foreign list does not exist #2');
			}

			return $this->foreign[$entityName][$fieldName];
		}

		public function existsForeign(string $fieldName, string $entityName = NULL): bool {
			$mainList = $this->getMainList();

			if ($entityName === NULL) {
				$entityName = $mainList->getName();
			}

			if ($mainList !== $this) {
				return $mainList->existsForeign($fieldName, $entityName);
			}

			if (!array_key_exists($entityName, $this->foreign)) {
				return false;
			}

			return array_key_exists($entityName, $this->foreign[$entityName]);
		}

		public function addSubData(ListDataInterface $list): ForeignContainerInterface {
			$mainList = $this->getMainList();

			if ($mainList !== $this) {
				return $mainList->addSubData($list);
			}

			$name = $list->getName();

			if (array_key_exists($name, $this->sublist)) {
				throw new ContainerException('SubData list already exist');
			}

			$this->sublist[$name] = $list;

			return $this;
		}

		public function getSubData(string $name): ListDataInterface {
			$mainList = $this->getMainList();

			if ($mainList !== $this) {
				return $mainList->getSubData($name);
			}

			if (!array_key_exists($name, $this->sublist)) {
				throw new ContainerException('SubData list does not exist');
			}

			return $this->sublist[$name];
		}

		public function existsSubData(string $name): bool {
			$mainList = $this->getMainList();

			if ($mainList !== $this) {
				return $mainList->existsSubData($name);
			}

			return array_key_exists($name, $this->sublist);
		}

		public function getEntity(): EntityInterface {
			return $this->entity;
		}

		public function setEntity(EntityInterface $entity) {
			$this->entity = $entity;
		}

		public function setFactoryForEntity(FactoryForEntityInterface $factory) {
			$this->factoryForEntity = $factory;
		}

		public function getFactoryForEntity(): FactoryForEntityInterface {
			return $this->factoryForEntity;
		}

		public function loadSubData($subNames = NULL) {

		}

		protected function assertForeignKeyInterface(ForeignKeyInterface $field): ForeignKeyInterface {
			return $field;
		}

		public function isMain(): bool {
			return $this === $this->getMainList();
		}

		public function loadForeignData() {
			$entity = $this->getEntity();
			$fieldSet = $entity->getFieldSet();
			$foreignInfo = $fieldSet->getForeignInfo();

			if (empty($foreignInfo)){
				return;
			}

			$factory = $this->getFactoryForEntity();
			$hub = $factory->getEntityHub();

			$list = $this->getMainList();

			foreach ($foreignInfo as $name => $f) {
				$field = $this->assertForeignKeyInterface($f);
				$whereIn = $list->getColumn($field->getName());
				$foreignEntity = $hub->get($name);
				$primaryKey = $foreignEntity->getPrimaryKey();

				$foreignList = $foreignEntity->readByIds($whereIn,
					function (SelectInterface $select) use ($field, $primaryKey) {
						$fields = $field->getForeignFields();
						$titleField = $field->getForeignTitleField();

						if (!empty($titleField)) {
							array_unshift($fields, "`$titleField` as '__title__'");
						}

						array_unshift($fields, "`$primaryKey` as '__id__'");
						array_unshift($fields, $primaryKey);

						$select->resetCols();
						$select->cols($fields);
					}
				);

				$this->addForeign($foreignList, $field->getName());
			}
		}
	}
}