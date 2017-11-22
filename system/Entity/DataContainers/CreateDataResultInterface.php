<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {
	interface CreateDataResultInterface {
		public function addCommonError(string $messageTemplate, array $templateData): CreateDataResultInterface;

		public function addFieldError(string $fieldName, string $messageTemplate, array $templateData): CreateDataResultInterface;

		public function hasError(): bool;

		public function isOk(): bool;

		public function getErrors(): array;

		public function setResult($result): CreateDataResultInterface;

		public function getResult();
	}
}