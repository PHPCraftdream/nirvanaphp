<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataProcess {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\CreateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\SaveDataManager as SDM;
	use PHPCraftdream\NirvanaPHP\Entity\EntityInterface;

	class SaveDataManager extends SDM implements SaveDataManagerInterface {
		protected $currentFieldName = '';
		protected $currentArgs = [];

		protected $entity = NULL;
		protected $result;


		public function getCurrentFieldName(): string {
			return $this->currentFieldName;
		}

		public function setCurrentFieldName(string $currentFieldName) {
			$this->currentFieldName = $currentFieldName;
		}

		public function getCurrentArgs() {
			return $this->currentArgs;
		}

		public function setCurrentArgs($currentArgs) {
			$this->currentArgs = $currentArgs;
		}

		//------------------------------------------------------------------------

		public function getEntity(): EntityInterface {
			return $this->entity;
		}

		public function setEntity(EntityInterface $entity) {
			$this->entity = $entity;
		}

		public function getResult(): CreateDataResultInterface {
			return $this->result;
		}

		public function setResult(CreateDataResultInterface $result) {
			$this->result = $result;
		}

		//------------------------------------------------------------------------

		public function appplyRule(string $field, string $rule, $args) {
			$entity = $this->getEntity();
			$dataRules = $entity->getEntityFactory()->getSaveDataRules();

			$this->setCurrentFieldName($field);
			$this->setCurrentArgs($args);

			$dataRules->assertMethodExists($rule, $field);
			$dataRules->{$rule}($this);
		}
	}
}