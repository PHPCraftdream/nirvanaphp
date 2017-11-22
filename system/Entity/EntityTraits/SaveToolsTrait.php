<?php

namespace PHPCraftdream\NirvanaPHP\Entity\EntityTraits {

	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataManagerInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataProcess\SaveDataRulesInterface;
	use PHPCraftdream\NirvanaPHP\Entity\EntityException;

	trait SaveToolsTrait {
		use MethodsTrait;

		protected function clearDataFields(array $data): array {
			$result = [];
			$fieldSet = $this->getFieldSet();

			foreach ($fieldSet->iterate() as $f) {
				$field = $fieldSet->assertField($f);
				$fieldName = $field->getName();

				if (!array_key_exists($fieldName, $data)) {
					continue;
				}

				if ($field->isVirtual()) {
					continue;
				}

				$result[$fieldName] = $data[$fieldName];
			}

			return $result;
		}

		protected function assertSaveDataNotEmpty(SaveDataManagerInterface $saveDataManager) {
			$data = $saveDataManager->getSaveData()->getAsIs();
			$result = $saveDataManager->getResult();

			if (empty($data)) {
				$result->addCommonError('empty_data', []);
			}
		}

		protected function assertMethodExists($obj, string $method, string $addMessage = '') {
			if (method_exists($obj, $method)) return;

			$className = get_class($obj);

			throw new EntityException("Error: {$addMessage}: assertMethodExists #1: {$className}.{$method}");
		}

		protected function processRules(SaveDataManagerInterface $saveDataManager, SaveDataRulesInterface $dataRules, array $rules) {
			if (empty($rules)) {
				return;
			}

			foreach ($rules as $ruleName => $args) {
				$saveDataManager->setCurrentArgs($args);

				$dataRules->assertMethodExists($ruleName, $saveDataManager->getCurrentFieldName());
				$dataRules->{$ruleName}($saveDataManager);
			}
		}

		protected function processSaveDataRules(SaveDataManagerInterface $saveDataManager, bool $create = true) {
			$fieldSet = $this->getFieldSet();
			$dataRules = $this->getSaveDataRules();

			foreach ($fieldSet->iterate() as $f) {
				$field = $fieldSet->assertField($f);
				$saveDataManager->setCurrentFieldName($field->getName());

				$rules = $create ? $field->getOnCreate() : $field->getOnUpdate();
				$saveRules = $field->getOnSave();

				$create ? $field->onCreate($saveDataManager) : $field->onUpdate($saveDataManager);
				$this->processRules($saveDataManager, $dataRules, $rules);
				$this->processRules($saveDataManager, $dataRules, $saveRules);
				$field->onSave($saveDataManager);
			}

			$this->assertSaveDataNotEmpty($saveDataManager);
		}

		protected function processCreateDataRules(SaveDataManagerInterface $saveDataManager) {
			$this->processSaveDataRules($saveDataManager, true);
		}

		protected function processUpdateDataRules(SaveDataManagerInterface $saveDataManager) {
			$this->processSaveDataRules($saveDataManager, false);
		}
	}
}