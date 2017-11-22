<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataProcess {

	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\CreateDataResultInterface;
	use PHPCraftdream\NirvanaPHP\Entity\DataContainers\SaveDataManagerInterface as SDMI;
	use PHPCraftdream\NirvanaPHP\Entity\EntityInterface;

	interface SaveDataManagerInterface extends SDMI {
		public function getCurrentFieldName(): string;

		public function setCurrentFieldName(string $currentFieldName);

		public function getCurrentArgs();

		public function setCurrentArgs($currentArgs);

		public function getEntity(): EntityInterface;

		public function setEntity(EntityInterface $entity);

		public function getResult(): CreateDataResultInterface;

		public function setResult(CreateDataResultInterface $result);

		public function appplyRule(string $field, string $rule, $args);
	}
}