<?php

namespace PHPCraftdream\NirvanaPHP\Entity\Fields {

	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;

	class ForeignKey extends Field implements ForeignKeyInterface {
		protected $data = [
			'name' => NULL,
			'title' => NULL,
			'placeholder' => NULL,
			'type' => 'int',
			'onCreate' => [],
			'onSave' => [],
			'onRead' => [],
			'onUpdate' => [],
			'onDelete' => [],
			'attrs' => [],
			'foreignEntity' => NULL,
			'foreignTitle' => NULL,
			'foreignFields' => NULL,
		];

		protected $sqlData = [
			'type' => 'INT',
			'length' => '11',
			'default' => NULL,
			'null' => false,
			'index' => 'INDEX `:name` (`:name`)',
		];

		public function __construct(string $name, string $entity, string $titleField, array $fields) {
			$this->data['name'] = $name;
			$this->data['foreignEntity'] = $entity;
			$this->data['foreignTitleField'] = $titleField;
			$this->data['foreignFields'] = $fields;
		}

		public function getForeignEntity(): string {
			return $this->data['foreignEntity'];
		}

		public function getForeignTitleField(): string {
			return $this->data['foreignTitleField'];
		}

		public function getForeignFields(): array {
			return $this->data['foreignFields'];
		}

		public function onCreate(SaveDataManagerInterface $dataManager) {
			$entityHub = $dataManager->getEntity()->getEntityFactory()->getEntityHub();
			$value = $dataManager->getSaveData()->get($this->getName());
			$entityName = $this->getForeignEntity();

			$fEntity = $entityHub->get($entityName);

			$exists = $fEntity->existsById($value);
			if ($exists) return;

			$result = $dataManager->getResult();
			$result->addFieldError($this->getName(), 'notExists[value]', ['value' => $value]);
		}

		public function onUpdate(SaveDataManagerInterface $dataManager) {
			$fieldName = $this->getName();
			$saveData = $dataManager->getSaveData();
			if (!$saveData->exists($fieldName)) return;

			$dbData = $dataManager->getDbData();

			$saveValue = $saveData->get($fieldName) . '';
			$dbValue = $dbData->get($fieldName) . '';

			if ($saveValue == $dbValue) return;

			$entityHub = $dataManager->getEntity()->getEntityFactory()->getEntityHub();
			$entityName = $this->getForeignEntity();

			$fEntity = $entityHub->get($entityName);

			$exists = $fEntity->existsById($saveValue);
			if ($exists) return;

			$result = $dataManager->getResult();
			$result->addFieldError($this->getName(), 'notExists[value]', ['value' => $saveValue]);
		}
	}
}