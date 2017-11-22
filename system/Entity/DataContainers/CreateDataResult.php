<?php

namespace PHPCraftdream\NirvanaPHP\Entity\DataContainers {
	class CreateDataResult implements CreateDataResultInterface {
		protected $fieldErrors = [];
		protected $commonErrors = [];
		protected $result = NULL;

		public function addCommonError(string $messageTemplate, array $templateData): CreateDataResultInterface {
			$this->commonErrors[] = [$messageTemplate, $templateData];

			return $this;
		}

		public function addFieldError(string $fieldName, string $messageTemplate, array $templateData): CreateDataResultInterface {
			if (empty($this->fieldErrors[$fieldName])) {
				$this->fieldErrors[$fieldName] = [];
			}

			$this->fieldErrors[$fieldName][] = [$messageTemplate, $templateData];

			return $this;
		}

		public function hasError(): bool {
			return !empty($this->fieldErrors) || !empty($this->commonErrors);
		}

		public function isOk(): bool {
			return empty($this->fieldErrors) && empty($this->commonErrors);
		}

		public function getErrors(): array {
			return [
				'fields' => $this->fieldErrors,
				'common' => $this->commonErrors,
			];
		}

		public function setResult($result): CreateDataResultInterface {
			$this->result = $result;
			return $this;
		}

		public function getResult() {
			return $this->result;
		}
	}
}