<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataProcess {

	use PHPCraftdream\NirvanaPHP\Bridges\QueryFactory\QueryFactoryInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityException;
	use PHPCraftdream\NirvanaPHP\Entity\FactoryForEntityInterface;
	use PHPCraftdream\NirvanaPHP\Tools\QueryExInterface;

	class SaveDataRules implements SaveDataRulesInterface {
		protected $core;
		protected $queryEx;
		protected $queryFactory;

		public function __construct(FactoryForEntityInterface $core) {
			$this->core = $core;
		}

		protected function getCore(): FactoryForEntityInterface {
			return $this->core;
		}

		protected function getQueryEx(): QueryExInterface {
			if (empty($this->queryEx)) {
				$this->queryEx = $this->getCore()->getQueryEx();
			}

			return $this->queryEx;
		}

		protected function getQueryFactory(): QueryFactoryInterface {
			if (empty($this->queryFactory)) {
				$this->queryFactory = $this->getCore()->getQueryFactory();
			}

			return $this->queryFactory;
		}

		public function assertMethodExists(string $method, string $addMessage = '', $obj = NULL) {
			$obj = empty($obj) ? $this : $obj;

			if (method_exists($obj, $method)) return;

			$className = get_class($obj);

			throw new EntityException("Error: {$addMessage}: assertMethodExists #1: {$className}.{$method}");
		}

		public function maxLength(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$result = $dataManager->getResult();
			$saveData = $dataManager->getSaveData();
			$length = $dataManager->getCurrentArgs();

			if (!$saveData->exists($fieldName)) {
				return;
			}

			$value = $saveData->get($fieldName) . '';

			if (mb_strlen($value) <= $length) {
				return;
			}

			$result->addFieldError($fieldName, 'maxLength[length]', ['length' => $length]);
		}

		public function minLength(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$result = $dataManager->getResult();
			$saveData = $dataManager->getSaveData();
			$length = $dataManager->getCurrentArgs();

			if (!$saveData->exists($fieldName)) {
				return;
			}

			$value = $saveData->get($fieldName) . '';

			if (mb_strlen($value) >= $length) {
				return;
			}

			$result->addFieldError($fieldName, 'minLength[length]', ['length' => $length]);
		}

		public function eqLength(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$result = $dataManager->getResult();
			$saveData = $dataManager->getSaveData();
			$length = $dataManager->getCurrentArgs();

			if (!$saveData->exists($fieldName)){
				return;
			}

			$value = $saveData->get($fieldName) . '';

			if (mb_strlen($value) === $length){
				return;
			}

			$result->addFieldError($fieldName, 'eqLength[length]', ['length' => $length]);
		}

		public function serialize(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$saveData = $dataManager->getSaveData();

			if (!$saveData->exists($fieldName)){
				return;
			}

			$value = $saveData->get($fieldName);
			$saveData->set($fieldName, serialize($value));
		}

		public function now(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$saveData = $dataManager->getSaveData();
			$saveData->set($fieldName, time());
		}

		public function delete(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$saveData = $dataManager->getSaveData();
			$saveData->delete($fieldName);
		}

		public function required(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$result = $dataManager->getResult();
			$saveData = $dataManager->getSaveData();

			if ($saveData->exists($fieldName)) {
				return;
			}

			$result->addFieldError($fieldName, 'Entity.field.required', ['field' => $fieldName]);
		}

		protected function getCount(string $table, string $fieldName, string $value): int {
			$queryFactory = $this->getQueryFactory();
			$queryEx = $this->getQueryEx();
			$select = $queryFactory->newSelect();

			$select->from($table);
			/** @noinspection PhpMethodParametersCountMismatchInspection */
			$select->where("$fieldName = ?", $value);

			$count = $queryEx->selectCount($select);

			return $count;
		}

		public function assertUniqueExists(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$result = $dataManager->getResult();
			$value = $dataManager->getSaveData()->get($fieldName);

			if ($value === NULL) {
				return;
			}

			$count = $this->getCount($dataManager->getEntity()->getTable(), $fieldName, $value);

			if ($count == 1) {
				return;
			}

			$result->addFieldError($fieldName, 'notUnique[value]', ['value' => $value]);
		}

		public function assertNotExists(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$result = $dataManager->getResult();
			$value = $dataManager->getSaveData()->get($fieldName);

			if ($value === NULL) {
				return;
			}

			$count = $this->getCount($dataManager->getEntity()->getTable(), $fieldName, $value);

			if ($count === 0) {
				return;
			}

			$result->addFieldError($fieldName, 'alreadyExists[value]', ['value' => $value]);
		}

		public function assertExists(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$result = $dataManager->getResult();
			$value = $dataManager->getSaveData()->get($fieldName);

			if ($value === NULL) {
				return;
			}

			$count = $this->getCount($dataManager->getEntity()->getTable(), $fieldName, $value);

			if ($count >= 1) {
				return;
			}

			$result->addFieldError($fieldName, 'notExists[value]', ['value' => $value]);
		}

		/** @noinspection SpellCheckingInspection */
		public function intval(SaveDataManagerInterface $dataManager) {
			$fieldName = $dataManager->getCurrentFieldName();
			$saveData = $dataManager->getSaveData();
			$value = $saveData->get($fieldName);

			$saveData->set($fieldName, intval($value));
		}
	}
}